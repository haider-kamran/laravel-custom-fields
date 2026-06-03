<?php

use Illuminate\Support\Facades\Route;
use HyderKamran\CustomFields\Http\Controllers\CustomFieldApiController;

$apiPrefix = config('custom-fields.api_prefix', 'api/custom-fields');
$apiMiddleware = config('custom-fields.api_middleware', ['api']);

if (config('custom-fields.api_enabled', true)) {
    Route::prefix($apiPrefix)->middleware($apiMiddleware)->group(function () {
        Route::get('/{modelType}/{modelId}', [CustomFieldApiController::class, 'getFields']);
        Route::post('/{modelType}/{modelId}', [CustomFieldApiController::class, 'saveFields']);
    });
}
