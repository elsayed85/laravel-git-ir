<?php

namespace Elsayed85\Gitir\Browser;

use Illuminate\Support\Facades\Http;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

class Browse
{
    private $crawler;

    private $base_url;

    public function __construct()
    {
        $this->base_url = config('git-ir.base_url');

        $crawler = new HttpBrowser(HttpClient::create([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029. Safari/537.3',
                'Accept-Language' => 'en-US,en;q=0.5',
            ],
        ]));

        $this->crawler = $crawler;
    }

    public function get($url, $data = [])
    {
        if(filter_var($url, FILTER_VALIDATE_URL)){
            return $this->crawler->request('GET', $url, $data);
        }

        return $this->crawler->request('GET', $this->base_url.$url, $data);
    }

    public function post($url, $data = [])
    {
        if(filter_var($url, FILTER_VALIDATE_URL)){
            return $this->crawler->request('POST', $url, $data);
        }
        return $this->crawler->request('POST', $this->base_url.$url, $data);
    }

    public function getCrawler()
    {
        return $this->crawler;
    }
}
