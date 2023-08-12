<?php


use Elsayed85\Gitir\Facades\Gitir;
use Illuminate\Support\Facades\Route;

Route::get("courses" , function(){
    $courses = Gitir::search(
        request("q") ,
        request("page" , 1),
        request("sort" , "newest"),
        request("perPage" , 12) ,
        request("cc" , false)
    );
    return response()->json($courses);
});


Route::get("courses/{slug}" , function($slug){
    $sections =  Gitir::course($slug);
    return response()->json($sections);
});
