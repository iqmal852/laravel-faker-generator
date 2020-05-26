<?php

use Iqmal\LaravelFakerGenerator\Http\Controllers\FakerGeneratorController;

Route::group([
    'as'     => 'faker',
    'prefix' => '/faker'
], function () {
    Route::get('/', [FakerGeneratorController::class, 'index']);
});
