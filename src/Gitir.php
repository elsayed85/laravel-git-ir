<?php

namespace Elsayed85\Gitir;

use Elsayed85\Gitir\Course\Course;
use Elsayed85\Gitir\Facades\Browse;
use Illuminate\Support\Collection;

class Gitir
{
    public function search($text, $page = 1, $sort = 'newest', $perPage = 12, $withCC = false): Collection
    {
        $query = http_build_query([
            's' => str_replace(' ', '+', $text),
            'page' => $page,
            'sort' => $sort,
            'pg' => $perPage,
            'cc' => $withCC ? 'on' : 'off',
        ]);
        $courses = Browse::get('courses'.'?'.$query)
            ->filter('main .container .row .col-12 > .row > div')
            ->each(function ($node) {
                $course = new Course();
                $course->title = $node->filter('.card-body h3')->text();
                $course->image = $node->filter('.post-item-image img')->attr('src');
                $course->url = $node->filter('a')->attr('href');
                $course->rating = $node->filter('.readonly-rating')->attr('data-average');
                $footer = $node->filter('.card-body div')->last()->filter('span');
                $course->time = $footer->first()->text('');
                if ($footer->count() == 3) {
                    $course->lang = $footer->eq(1)->text('');
                }
                $course->level = $footer->last()->text('');

                return $course;
            });

        return Collection::make($courses);
    }

    public function course(Course $course)
    {
        $browse = Browse::get($course->url)->filter('main');

        $sections = $browse->filter('div.course-lectures')->each(function ($node) {
            $header = $node->filter('.course-lecture-header h2')->text('');
            $lectures = $node->filter('.course-lecture-list .list-group a')->each(function ($a) {
                $index = $a->attr('data-index');
                $video = $a->attr('data-signature');
                $srt = $a->attr('data-signature2');
                $title = $a->filter('h3')->text('');

                return [
                    'index' => $index,
                    'video' => base64_decode($video),
                    'srt' => base64_decode($srt),
                    'title' => $title,
                ];
            });

            return [
                'header' => $header,
                'lectures' => $lectures,
            ];
        });

        $course->sections = $sections;

        return $course;
    }
}
