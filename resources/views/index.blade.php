<?php
/**
 *
 */
?>

@extends('layouts.default')

@section('page_title', 'White Trash Fabulous')

@section('content')
<div class="container">
    <h2>Blockchain Analysis</h2>
    <ul>
        <li><a href="/coin/btc">Bitcoin (BTC)</a></li>
    </ul>
</div>

<div class="container">
    <h2>All Currencies</h2>
    <table class="table table-hover table-sm table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Algorithm</th>
                <th scope="col">ProofType</th>
                <th scope="col">TotalCoinSupply</th>
            </tr>
        </thead>

        <tbody>
        @foreach ($coins as $coin)
            <tr>
                <td>{{ $coin->FullName }}</td>
                <td>{{ $coin->Algorithm }}</td>
                <td>{{ $coin->ProofType }}</td>
                <td>{{ $coin->TotalCoinSupply }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection