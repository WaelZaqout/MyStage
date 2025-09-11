<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeWebhookController;

Route::prefix('')->group(function () {
    Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);
});
