<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'namespace'  => 'Frontend',
],function (){
    Route::get('/', 'HomeController@index')->name('home');
    //after login
    Route::group([
        'middleware' =>  ['auth','web']
    ],function (){

    });
});
Auth::routes();
Route::group([
    'prefix'     => 'mng',
    'namespace'  => 'Admin',
    'middleware' => 'web',
], function () {

    // Guest
    Route::group([
        'middleware' => 'guest:admin',
        'namespace'  => 'Auth'
    ], function () {
        Route::get('/', function () {
            return redirect(route('admin.login'));
        });
        Route::get('login', 'LoginController@showLoginForm')->name('admin.login');;
        Route::post('login', 'LoginController@login');
    });

    Route::group([
        'middleware' => 'auth:admin'
    ],function (){
        Route::group([
            'prefix' => 'laravel-filemanager',
        ], function () {
            Lfm::routes();
        });
        Route::group([
            'prefix' => 'api',
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
        });
        //Admin
        Route::get('/', 'DashboardController@index')->name('admin.dashboard.index');
        Route::post('logout', 'Auth/LoginController@logout')->name('admin.logout');

        Route::get('comment', 'CommentController@index')->name('admin.comment.index');
        Route::get('feedback', 'FeedbackController@index')->name('admin.feedback.index');

        Route::group([
            'prefix' => 'customer',
            'namespace' => 'Customer'
        ], function () {
            Route::get('/', 'CustomerController@index')->name('admin.customer.index');
        });

        Route::group([
            'prefix' => 'config'
        ], function () {
            Route::get('/', 'ConfigController@index')->name('admin.config.index');
        });

        Route::group([
            'namespace' => 'News'
        ], function () {
            Route::group([
                'prefix' => 'category'
            ], function () {
                Route::get('/', 'CategoryController@index')->name('admin.category.index');
            });
            Route::group([
                'prefix' => 'news'
            ], function () {
                Route::get('/', 'NewsController@index')->name('admin.news.index');
                Route::get('edit/{id}', 'NewsController@edit')->name('admin.news.edit');
                Route::get('create', 'NewsController@create')->name('admin.news.create');
                Route::post('create', 'NewsController@store')->name('admin.news.store');
                Route::put('update/{id}', 'NewsController@update')->name('admin.news.update');
            });
            Route::group([
                'prefix' => 'tag'
            ], function () {
                Route::get('/', 'TagController@index')->name('admin.tag.index');
            });
        });
        Route::group([
            'namespace' => 'Product'
        ], function () {
            Route::group([
                'prefix' => 'product'
            ], function () {
                Route::get('/', 'ProductController@index')->name('admin.product.index');
                Route::get('create', 'ProductController@create')->name('admin.product.create');

            });
            Route::group([
                'prefix' => 'category'
            ], function () {
                Route::get('/', 'CategoryController@index')->name('admin.category.index');
            });
        });
    });
});
