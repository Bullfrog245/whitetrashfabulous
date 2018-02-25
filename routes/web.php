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

    $apiContext = resolve('BlockCypher\Rest\ApiContext');
    $symbol = strtoupper($coin);
    $messages = '';

    try {
        $chain = \BlockCypher\Api\Chain::get("{$symbol}.main", array(), $apiContext);
        $hash = $chain->previous_hash;
    } catch (Exception $e) {
        $messages = $e->getMessage();
        $chain = App\Block::latest('time')->first();
        $hash = $chain->prev_block;
    }
    
    $blocks = [];
    for ($i = 0; $i < 20; $hash = $block->prev_block) {
        $block = App\Block::find($hash);

        if (empty($block)) {
            try {
                $block = \BlockCypher\Api\Block::get(
                    $hash,
                    array('limit' => 1),
                    $apiContext
                );
                
                $block = App\Block::create([
                    'hash' => $block->hash,
                    'prev_block' => $block->prev_block,
                    'symbol' => 'BTC',
                    'height' => $block->height,
                    'n_tx' => $block->n_tx,
                    'total' => $block->total,
                    'fees' => $block->fees,
                    'time' => strtotime($block->time),
                ]);

                ++$i;
            } catch (Exception $e) {
                $messages = $e->getMessage();
                break;
            }
        }

        $blocks[] = $block;
    }


    return view('coin', compact('blocks', 'messages'));
});