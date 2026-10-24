<?php
use Illuminate\Support\Facades\Route;

Route::get('/suppliers', function () {
    return view('suppliers.index');
});

Route::get('/', function () {
    return redirect('/suppliers');
});