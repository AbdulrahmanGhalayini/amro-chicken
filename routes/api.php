<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerApiController;

Route::post('/customers/add', [CustomerApiController::class, 'addCustomer'])->name('customers.add');
