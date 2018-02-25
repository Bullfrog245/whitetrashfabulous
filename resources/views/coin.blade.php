<?php
/**
 *
 */
?>

@extends('layouts.default')

@section('page_title', 'BTC Blockchain')

@section('content')
<div class="container">
    <h2>Analysis of the <strong>Bitcoin (BTC)</strong> Blockchain</h2>
    @if (!empty($messages))
    <div class="alert alert-warning" role="alert">
        {{ $messages }}
    </div>
    @endif
    <table class="table table-hover table-sm table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Hash</th>
                <th scope="col">Height</th>
                <th scope="col">Time</th>
                <th class="text-right" scope="col">Txns</th>
                <th class="text-right" scope="col">Total (Satoshi)</th>
                <th class="text-right" scope="col">Total (BTC)</th>
                <th class="text-right" scope="col">Fees (Satoshi)</th>
                <th class="text-right" scope="col">Fees (BTC)</th>
            </tr>
        </thead>
        <tbody>
        @foreach($blocks as $block)
            <tr>
                <td><pre>{{ substr($block->hash, 18, 7) }}</pre></td>
                <td><pre>{{ $block->height }}</pre></td>
                <td><pre>{{ date('Y-m-d\Tg:i:s\Z', $block->time) }}</pre></td>
                <td class="text-right"><pre>{{ $block->n_tx }}</pre></td>
                <td class="text-right">
                    <pre>{{ $block->total }}</pre>
                </td>
                <td class="text-right">
                    <pre>{{ number_format($block->total / 100000000, 8, '.', '') }}</pre>
                </td>
                <td class="text-right">
                    <pre>{{ $block->fees }}</pre>
                </td>
                <td class="text-right">
                    <pre>{{ number_format($block->fees / 100000000, 8, '.', '') }}</pre>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection