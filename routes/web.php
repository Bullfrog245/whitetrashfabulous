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

use App\Block;

Route::get('/', function () {
    if (Cache::has( 'coinlist')) {
		$coins = Cache::get('coinlist');
	} else {
        $coins = json_decode(file_get_contents('https://min-api.cryptocompare.com/data/all/coinlist'))->Data;
		Cache::put('coinlist', $coins, 1440);
	}
    return view('index', compact('coins'));
});

Route::get('/coin/{coin}', function ($coin) {
    $symbol = strtoupper($coin);
    $blocks = Block::where('symbol', $symbol)->orderBy('time', 'desc')->get();
    
    return view('coin', compact('blocks'));
});