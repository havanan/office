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
