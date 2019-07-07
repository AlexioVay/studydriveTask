<?php

use App\JSON;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
    #return view('home')->with(['content' => $project->content()]);
});
Route::get('/json', function () {
    $JSON = new JSON();
    return view('json')->with(['output' => json_encode($JSON->output(), true)]);
});
Route::get('/imprint', function () {
    return view('imprint');
});
Route::get('/privacy-policy', function () {
    return view('privacy');
});
Route::get('/terms-of-service', function () {
    return view('terms_of_service');
});

Route::post('/fav-{id}', 'FavController@update');


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
