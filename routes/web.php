<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::controller(Home::class)->group(function(){
    Route::get('/', 'index')->name('home');
    Route::post('/login', 'login');
    Route::post('/regist', 'register');
    Route::get('/logout', 'logout');
    Route::get('/fetching-lapangan', 'fetching_lapangan');
    Route::get('/lapangan/{num}', 'detail_lapangan');
    Route::get('/merchant/{num}', 'detail_merchant');
    Route::get('/get-jadwal-lapangan/{num}', 'get_jadwal_lapangan');
    Route::get('/get-message', 'get_message');
    Route::get('/get-unread-message', 'get_unread_message');
    Route::post('/send-message', 'sending_message');
});
Route::controller(Dashboard::class)->group(function(){
    Route::get('/dashboard', 'index')->middleware('auth');
    // Route::get('/settings/{num?}', 'setting')->middleware('auth');
    Route::get('/settings/{num?}', 'setting')->middleware('auth');
    Route::post('/settings/{num?}', 'settingStore')->middleware('auth');
    Route::get('/merchant-regist', 'merchant_register')->middleware('auth');
    Route::post('/merchant-regist', 'merchant_register_store')->middleware('auth');
    Route::get('/user-booklists', 'book_lapangan');
    Route::get('/merchant-lapangan', 'lapangan');
    Route::get('/merchant-lapangan/{num}', 'lapangan_ini');
    Route::get('/add-transaction/{num}', 'add_transaction')->middleware('auth');
    Route::get('/add-lapangan', 'lapangan_store');
    Route::post('/add-lapangan', 'add_lapangan_store');
    Route::post('/admin-merchant-status', 'merchant_status_change');
    Route::post('/delete-trans', 'deleting_transaction');
    Route::post('/book-date', 'booking_date');
    Route::post('/save-review', 'saving_review');
    Route::get('/user-transactions', 'trans_lapangan')->middleware('auth');
    Route::post('/complete-transaction', 'completing_transaction')->middleware('auth');
    Route::get('/admin-merchant', 'merchant_list');
    Route::get('/cek-transaksi', 'checking_transaction');
    Route::get('/request-balance', 'request_balance');
    Route::post('/request-balance', 'requesting_balance');
    Route::get('/request-saldo', 'request_saldo');
    Route::post('/request-saldo', 'requesting_saldo');
    // Route::get('/user-transactions', 'book_lapangan');
    // Route::post('/login', 'login');
    Route::get('/registes', 'tesget');
});
    