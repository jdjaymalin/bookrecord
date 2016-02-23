<?php

Route::group(['middleware' => ['web']], function () {

    Route::post('/books/upload', 'FileController@upload');
    Route::get('/books/import', 'FileController@import');
    Route::get('/books/write', 'BookController@write');
    Route::get('/books/sort', 'BookController@sort');
    Route::post('/books/search', ['as' => 'books.index', 'uses' => 'BookController@search']);
    Route::resource('/books', 'BookController');
});

