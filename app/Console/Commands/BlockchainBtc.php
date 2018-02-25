<?php

namespace App\Console\Commands;

use \App\Block;
use Illuminate\Console\Command;

class BlockchainBtc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blockchainbtc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'BTC blockchain updated';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Attempt to get the latest block. If we get it, retrieve the hash
        // for further analysis
        try {
            $chain = json_decode(file_get_contents('https://blockchain.info/latestblock'));
            $hash = $chain->hash;
        } catch (Exception $e) {
            return false;
        }
        
        // Get all of the blocks we have cached
        $blocks = Block::where('symbol', 'BTC')->get()->keyBy('hash');

        // Starting with the laster block, iterate through the blockchain
        // collection data as necessary. To play nice with the various API
        // providers, we only obtain a few blocks each invocation
        for ($i = 0; $i < 5; $hash = $block->prev_block) {
            // Only update for one day
            if (isset($block)) {
                if (env('APP_ENV') == 'local' && $block->time < strtotime('-1 day'))
                    break; 
                elseif ($block->time < strtotime('-1 year'))
                    break;
            }

            // If we've already cached the block, don't call the API
            if ($blocks->contains('hash', $hash)) {
                $block = $blocks->firstWhere('hash', $hash);
            } else {
                try {
                    $block = json_decode(file_get_contents('https://blockchain.info/rawblock/' . $hash));
    
                    // blockchain.info doesn't have a "total" field. We need
                    // to manually tally the value of all transactions in
                    // the block
                    $total = 0;
                    foreach ($block->tx as $tx) {
                        foreach ($tx->out as $out) {
                            $total += $out->value;
                        }
                    }
                    
                    // Cache the retrieved block
                    $block = \App\Block::create([
                        'hash' => $block->hash,
                        'prev_block' => $block->prev_block,
                        'symbol' => 'BTC',
                        'height' => (string) $block->height,
                        'n_tx' => (string) $block->n_tx,
                        'total' => (string) $total,
                        'fees' => (string) $block->fee,
                        'time' => $block->time,
                    ]);
    
                    // Increment our counter only if an API call was used
                    ++$i;
                } catch (Exception $e) {
                    return false;
                }
            }
        }
    }
}
