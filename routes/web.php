<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

// get('URLリクエスト', '対象コントローラー@対象メソッド')
Route::get('/', 'DiaryController@index')->name('diary.index'); //追加

Route::get('diary/create', 'DiaryController@create')->name('diary.create'); //追加

// オブジェクト指向のクラスメッソッド
// クラス名：：メソッド
// オブジェクト->メソッド

// class Car {
//   function start() {

//   }
// }

// $car = new Car();
// $car->start();

// Car::start();
