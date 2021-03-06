<?php

use Iqmal\LaravelFakerGenerator\Http\Controllers\FakerGeneratorController;

Route::group([
    'as'     => 'laravel-faker-generator.',
    'prefix' => '/faker',
    'middleware' => 'web'
], function () {
    Route::get('/', [FakerGeneratorController::class, 'index'])->name('index');
    Route::get('/create/', [FakerGeneratorController::class, 'create'])->name('create');
    Route::get('/create/{table}', [FakerGeneratorController::class, 'show'])->name('create.faker');
    Route::post('/create/{table}', [FakerGeneratorController::class, 'generate'])->name('generate.faker');
    Route::get('/run/{class}', [FakerGeneratorController::class, 'run'])->name('run');
    Route::get('/delete/{class}', [FakerGeneratorController::class, 'destroy'])->name('destroy');
});
