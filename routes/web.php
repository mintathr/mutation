<?php

use App\Http\Livewire\ContactIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', 'AuthController@showFormLogin')->name('login');
Route::get('login', 'AuthController@showFormLogin')->name('login');
Route::post('login', 'AuthController@login');
Route::get('register', 'AuthController@showFormRegister')->name('register');
Route::post('register', 'AuthController@register');

Route::group(['middleware' => 'auth'], function () {

    Route::get('home', 'HomeController@index')->name('home');
    Route::get('logout', 'AuthController@logout')->name('logout');

    //mutations
    Route::get('/mutation', 'MutationController@index')->name('mutation');
    Route::get('/mutation/create', 'MutationController@create')->name('mutation.create');
    Route::post('/mutation', 'MutationController@store');
    Route::get('/mutasi-bca/{id}', 'MutationController@showbank')->name('mutation.m_bca');
    Route::get('/mutasi-bni/{id}', 'MutationController@showbank')->name('mutation.m_bni');
    Route::get('/mutasi-cimb/{id}', 'MutationController@showbank')->name('mutation.m_cimb');
    Route::get('/mutasi-dbs/{id}', 'MutationController@showbank')->name('mutation.m_dbs');
    Route::get('/mutasi-danamon/{id}', 'MutationController@showbank')->name('mutation.m_danamon');
    Route::get('/mutasi-panin/{id}', 'MutationController@showbank')->name('mutation.m_panin');
    Route::get('/mutasi-cc-bca/{id}', 'MutationController@showbank')->name('mutation.m_cc-bca');
    Route::get('/mutasi-cc-niaga-master/{id}', 'MutationController@showbank')->name('mutation.m_cc-niaga-master');
    Route::get('/mutasi-cc-niaga-syariah/{id}', 'MutationController@showbank')->name('mutation.m_cc-niaga-syariah');
    Route::get('/mutasi-cc-panin/{id}', 'MutationController@showbank')->name('mutation.m_cc-panin');
    Route::get('/mutasi-cash/{id}', 'MutationController@showbank')->name('mutation.m_cash');
    Route::get('/mutasi-gopay/{id}', 'MutationController@showbank')->name('mutation.m_gopay');
    Route::get('/mutasi-ovo/{id}', 'MutationController@showbank')->name('mutation.m_ovo');
    Route::get('/mutasi-shopee-pay/{id}', 'MutationController@showbank')->name('mutation.m_shopee_pay');

    //user
    Route::get('/user', 'UserController@index')->name('user');
    Route::put('{user}', 'UserController@aktivasi');

    //contact
    Route::get('/contact', 'ContactController@index')->name('contact');
});
