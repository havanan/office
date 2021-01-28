<?php
use Illuminate\Support\Facades\Route;

Route::group([

    'namespace'  => 'Admin',
], function() {
    Route::group(['prefix' => 'comment'], function() {
        Route::get('/', 'CommentController@getList');
        Route::get('/{id}/{status}', 'CommentController@updateStatus');
        Route::post('/{id}', 'CommentController@replyCommentByAdmin');
        Route::delete('/{id}', 'CommentController@destroy');
    });
    Route::group([
        'prefix' => 'customer',
        'namespace' => 'Customer'
    ], function() {
        Route::get('/',         'CustomerController@getList');
        Route::post('/',        'CustomerController@store');
        Route::post('update-by-field','CustomerController@updateByField');
        Route::put('/{id}',     'CustomerController@update');
        Route::delete('/{id}',  'CustomerController@destroy');
    });
    Route::group(['prefix' => 'config'], function() {
        Route::get('/',         'ConfigController@getList');
        Route::post('/',        'ConfigController@store');
        Route::put('/{id}',     'ConfigController@update');
        Route::delete('/{id}',  'ConfigController@destroy');
    });
    Route::group([
        'namespace' => 'News'
    ],function (){

        Route::group([
            'prefix' => 'category',
        ], function() {
            Route::get('/',         'CategoryController@getList');
            Route::post('/',        'CategoryController@store');
            Route::put('/{id}',     'CategoryController@update');
            Route::delete('/{id}',  'CategoryController@destroy');
        });

        Route::group([
            'prefix' => 'news',
        ], function() {
            Route::get('/',         'NewsController@getList');
            Route::get('find',      'NewsController@findById');
            Route::delete('/{id}',  'NewsController@destroy');
        });

        Route::group([
            'prefix' => 'tag',
        ], function() {
            Route::get('/',         'TagController@getList');
            Route::get('find',      'TagController@find');
            Route::post('/',        'TagController@store');
            Route::put('/{id}',     'TagController@update');
            Route::delete('/{id}',  'TagController@destroy');
        });

    });
    Route::group([
        'prefix' => 'feedback',
    ], function() {
        Route::get('/',         'FeedbackController@getList');
        Route::get('status/{id}','FeedbackController@changeStatus');
        Route::get('find',      'FeedbackController@find');
        Route::post('/',        'FeedbackController@store');
        Route::put('/{id}',     'FeedbackController@update');
        Route::delete('/{id}',  'FeedbackController@destroy');
    });
    Route::group([
        'prefix' => 'user',
    ], function() {
        Route::get('/',         'UserController@getList');
        Route::post('/',        'UserController@store');
        Route::put('/{id}',     'UserController@update');
        Route::delete('/{id}',  'UserController@destroy');
    });
    //Supper Admin
//    Route::group(['middleware' => 'supper_admin'],function (){
//
//        Route::get('invoice', 'InvoiceController@getList');
//        Route::get('report',  'ReportController@getReport');
//    });
});
