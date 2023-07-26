<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\SingleActionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\RegistrationController;
use App\Models\Customer;
use Illuminate\Http\Request;

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

Route::get('/',[DemoController::class,'index']);
Route::get('/about','App\Http\Controllers\DemoController@about');
Route::get('/courses',SingleActionController::class);
Route::resource('photo', PhotoController::class);
Route::get('/register',[RegistrationController::class,'index']);
Route::post('/register',[RegistrationController::class,'register']);
Route::get('/registeration',function(){
    return view('registration');
});
Route::get('/master',function(){
    return view('registration');
});

Route::get('customer/create',[CustomerController::class,'create'])->name('customer.create');
Route::post('customer',[CustomerController::class,'store']);
Route::get('customer',[CustomerController::class,'view']);
Route::get('customer/trash',[CustomerController::class,'trash']);
Route::get('customer/delete/{id}',[CustomerController::class,'delete'])->name('customer.delete');
Route::get('customer/restore/{id}',[CustomerController::class,'restore'])->name('customer.restore');
Route::get('customer/force-delete/{id}',[CustomerController::class,'forceDelete'])->name('customer.force-delete');
Route::get('customer/edit/{id}',[CustomerController::class,'edit'])->name('customer.edit');
Route::post('customer/update/{id}',[CustomerController::class,'update'])->name('customer.update');
Route::get('/',function(){
    return view('index');
});
Route::get('/get-all-session',function(){
    $session = session()->all();  
    p($session); 
});
Route::get('/set-session',function(Request $request){
    $request->session()->put('user_name','Leo');
    $request->session()->put('user_id','123');
    $request->session()->flash('status','Success');
    return redirect('get-all-session');
});
Route::get('/destroy-session',function(Request $request){
    session()->forget('user_name');
    session()->forget('user_id');
    return redirect('get-all-session');
});