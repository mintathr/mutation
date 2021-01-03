<?php

use App\Http\Livewire\ContactIndex;
use App\Http\Livewire\BankIndex;
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
    Route::get('/mutation/funds', 'MutationController@funds')->name('mutation/v_funds');
    #Route::get('/mutation/{account}/{slug}/{id}', 'MutationController@fundsedit');
    Route::get('/mutation/{id}/{bank:slug}', 'MutationController@fundsedit');
    Route::get('/mutasi/{bank:slug}/transfer/{id}', 'MutationController@debit')->name('mutation.debit');
    Route::get('/mutasi/{bank:slug}/topup/{id}', 'MutationController@credit')->name('mutation.credit');
    Route::get('/mutasi/{bank:slug}/bayar/{id}', 'MutationController@bayarDetail')->name('mutation.bayar_detail');
    Route::get('/mutasi/{bank:slug}/tarik/{id}', 'MutationController@tarik')->name('mutation.tarik');
    Route::post('/mutation', 'MutationController@store');
    Route::post('/mutation/credit', 'MutationController@storeCredit');
    Route::post('/mutasi/bayar', 'MutationController@storeBayarDetail');
    Route::post('/mutation/tarik', 'MutationController@storeTarik');
    Route::get('/mutation', 'MutationController@index')->name('mutation');

    Route::get('/mutation/transfer', 'MutationController@transfer')->name('mutation.transfer');
    Route::post('/mutation/transfer', 'MutationController@transferStore');
    Route::get('/mutation/bayar', 'MutationController@bayar')->name('mutation.bayar');
    Route::post('/mutation/bayar', 'MutationController@bayarStore');
    Route::get('/mutation/penerimaan', 'MutationController@penerimaan')->name('mutation.penerimaan');
    Route::post('/mutation/penerimaan', 'MutationController@penerimaanStore');
    Route::get('/mutation/tarik-tunai', 'MutationController@tarikTunai')->name('mutation.tarik-tunai');
    Route::post('/mutation/tarik-tunai', 'MutationController@tarikTunaiStore');



    /* Route::get('/mutation/create', 'MutationController@create')->name('mutation.create');
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
    Route::get('/mutasi-shopee-pay/{id}', 'MutationController@showbank')->name('mutation.m_shopee_pay'); */


    //bank
    #Route::get('/banks', 'BankController@index')->name('bank.lw-index');
    Route::get('/banks', function () {
        return view('bank.lw-index');
    });

    //account
    Route::get('/rekening', function () {
        return view('account-merchant');
    });

    //user
    Route::get('/user', 'UserController@index')->name('user');
    Route::put('{user}', 'UserController@aktivasi');

    //contact
    Route::get('/contact', 'ContactController@index')->name('contact');
});
