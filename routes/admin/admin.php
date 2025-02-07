<?php

use App\Http\Controllers\admin\CategoryTheme\ThemeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth:sanctum', 'role:admin'])->group( function () {
  Route::apiResource('category', ThemeController::class);
         
    });