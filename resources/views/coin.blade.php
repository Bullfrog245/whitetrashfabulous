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
                <th scope="col">Time</th>
                <th scope="col">Transactions</th>
                <th scope="col">Total</th>
                <th scope="col">Fees</th>
            </tr>
        </thead>
        <tbody>
        @foreach($blocks as $block)
            <tr>
                <td>{{ $block->hash }}</td>
                <td>{{ $block->time }}</td>
                <td>{{ $block->n_tx }}</td>
                <td>{{ $block->total }}</td>
                <td>{{ $block->fees }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection