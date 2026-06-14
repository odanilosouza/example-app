<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\VisitReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register-request', [AuthController::class, 'registerRequest']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('auth/me', [AuthController::class, 'me']);
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/change-password', [AuthController::class, 'changePassword']);

    Route::get('dashboard/client', [DashboardController::class, 'client']);
    Route::get('dashboard/admin', [DashboardController::class, 'admin']);

    Route::apiResource('clients', ClientController::class)->only(['index', 'show', 'update']);
    Route::get('clients/{client}/history', [ClientController::class, 'history']);

    Route::apiResource('documents', DocumentController::class)->except(['edit', 'create']);
    Route::get('documents/{document}/download', [DocumentController::class, 'download']);

    Route::apiResource('reports', ReportController::class)->except(['edit', 'create']);
    Route::get('reports/{report}/download', [ReportController::class, 'download']);

    Route::apiResource('images', ImageController::class)->except(['edit', 'create']);
    Route::apiResource('visit-reports', VisitReportController::class)->except(['edit', 'create']);
    Route::get('visit-reports/{visit_report}/download', [VisitReportController::class, 'download']);

    Route::get('history', [HistoryController::class, 'index']);

    Route::get('notifications', [NotificationController::class, 'index']);
    Route::post('notifications/mark-read', [NotificationController::class, 'markRead']);
    Route::get('notifications/count', [NotificationController::class, 'count']);

    Route::get('settings', [SettingController::class, 'index']);
    Route::put('settings', [SettingController::class, 'update']);
});

Route::post('contact', [ContactController::class, 'send']);
