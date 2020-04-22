<?php

Route::post('/register','Api\AuthController@register');
Route::post('/login','Api\AuthController@login');


Route::group(['middleware' => 'auth:api'], function () {
    //feed
    Route::get('/feed','Api\FeedApi@feed');
    Route::post('/feed/create','Api\FeedApi@create');
    Route::delete('/feed/delete/{feed}','Api\FeedApi@delete');

    //comment
    Route::post('/comment/all','Api\FeedApi@getcomment');
    Route::post('/create/comment','Api\FeedApi@createcomment');
    Route::delete('comment/delete','Api\FeedApi@deletecomment');

    //Like
    Route::post('/like','Api\LikeController@like');
    Route::delete('/dislike','Api\LikeController@dislike');

    Route::post('/logout','Api\AuthController@logout');

    

});
