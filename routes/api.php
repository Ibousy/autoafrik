<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\AppNotificationController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockItemController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {

    // ── Company settings — owner & admin only
    Route::middleware('role:owner,admin')->group(function () {
        Route::get('company',       [CompanyController::class, 'show']);
        Route::put('company',       [CompanyController::class, 'update']);
        Route::post('company/logo', [CompanyController::class, 'uploadLogo']);
    });
    Route::get('plans', [CompanyController::class, 'plans']); // all (needed by settings page)

    // ── Agents — owner & admin only
    Route::middleware('role:owner,admin')->group(function () {
        Route::apiResource('agents', AgentController::class)->except(['show']);
    });

    // ── Clients — owner, admin, manager, receptionist
    Route::middleware('role:owner,admin,manager,receptionist')->group(function () {
        Route::get('clients/stats', [ClientController::class, 'stats']);
        Route::apiResource('clients', ClientController::class);
    });

    // ── Vehicles — everyone except accountant (mechanic: read-only)
    Route::middleware('role:owner,admin,manager,mechanic,receptionist')->group(function () {
        Route::get('vehicles/stats', [VehicleController::class, 'stats']);
        Route::get('vehicles',        [VehicleController::class, 'index']);
        Route::get('vehicles/{vehicle}', [VehicleController::class, 'show']);
    });
    Route::middleware('role:owner,admin,manager,receptionist')->group(function () {
        Route::post('vehicles',           [VehicleController::class, 'store']);
        Route::put('vehicles/{vehicle}',  [VehicleController::class, 'update']);
        Route::patch('vehicles/{vehicle}',[VehicleController::class, 'update']);
        Route::delete('vehicles/{vehicle}',[VehicleController::class, 'destroy']);
    });

    // ── Maintenances — owner, admin, manager, mechanic
    Route::middleware('role:owner,admin,manager,mechanic')->group(function () {
        Route::get('maintenances/vehicles-list',[MaintenanceController::class, 'vehiclesList']);
        Route::get('maintenances/clients-list', [MaintenanceController::class, 'clientsList']);
        Route::get('maintenances',              [MaintenanceController::class, 'index']);
        Route::post('maintenances',             [MaintenanceController::class, 'store']);
        Route::patch('maintenances/{maintenance}', [MaintenanceController::class, 'update']);
        Route::delete('maintenances/{maintenance}',[MaintenanceController::class, 'destroy']);
    });

    // ── Repairs — owner, admin, manager, mechanic
    Route::middleware('role:owner,admin,manager,mechanic')->group(function () {
        Route::get('repairs/stats',                    [RepairController::class, 'stats']);
        Route::apiResource('repairs',                   RepairController::class);
        Route::post('repairs/{repair}/parts',          [RepairController::class, 'addPart']);
        Route::delete('repairs/{repair}/parts/{part}', [RepairController::class, 'removePart']);
    });

    // ── Rentals — owner, admin, manager, receptionist
    Route::middleware('role:owner,admin,manager,receptionist')->group(function () {
        Route::get('rentals/stats', [RentalController::class, 'stats']);
        Route::apiResource('rentals', RentalController::class);
    });

    // ── Stock — owner, admin, manager, mechanic
    Route::middleware('role:owner,admin,manager,mechanic')->group(function () {
        Route::get('stock/stats',                  [StockItemController::class, 'stats']);
        Route::get('stock',                        [StockItemController::class, 'index']);
        Route::get('stock/{stock}',                [StockItemController::class, 'show']);
        Route::post('stock/{stock_item}/restock',  [StockItemController::class, 'restock']);
    });
    Route::middleware('role:owner,admin,manager')->group(function () {
        Route::post('stock',             [StockItemController::class, 'store']);
        Route::put('stock/{stock}',      [StockItemController::class, 'update']);
        Route::patch('stock/{stock}',    [StockItemController::class, 'update']);
        Route::delete('stock/{stock}',   [StockItemController::class, 'destroy']);
    });

    // ── Employees — owner, admin, manager
    Route::middleware('role:owner,admin,manager')->group(function () {
        Route::get('employees/stats', [EmployeeController::class, 'stats']);
        Route::apiResource('employees', EmployeeController::class);
    });

    // ── Transactions — owner, admin, accountant (manager: read-only)
    Route::middleware('role:owner,admin,accountant,manager')->group(function () {
        Route::get('transactions/summary', [TransactionController::class, 'summary']);
        Route::get('transactions',         [TransactionController::class, 'index']);
        Route::get('transactions/{transaction}', [TransactionController::class, 'show']);
    });
    Route::middleware('role:owner,admin,accountant')->group(function () {
        Route::post('transactions',              [TransactionController::class, 'store']);
        Route::put('transactions/{transaction}', [TransactionController::class, 'update']);
        Route::patch('transactions/{transaction}',[TransactionController::class, 'update']);
        Route::delete('transactions/{transaction}',[TransactionController::class, 'destroy']);
    });

    // ── Reports — owner, admin, manager, accountant
    Route::middleware('role:owner,admin,manager,accountant')->group(function () {
        Route::prefix('reports')->group(function () {
            Route::get('monthly',          [ReportController::class, 'monthly']);
            Route::get('repairs-category', [ReportController::class, 'repairsByCategory']);
            Route::get('top-mechanics',    [ReportController::class, 'topMechanics']);
            Route::get('top-vehicles',     [ReportController::class, 'topVehicles']);
            Route::get('top-clients',      [ReportController::class, 'topClients']);
        });
    });

    // ── Notifications & Messaging — all authenticated users
    Route::get('app-notifications',                  [AppNotificationController::class, 'index']);
    Route::put('app-notifications/read-all',         [AppNotificationController::class, 'readAll']);
    Route::put('app-notifications/{notification}/read', [AppNotificationController::class, 'read']);

    Route::get('team-members',      [AgentController::class,   'teamMembers']);

    Route::get('messages',          [MessageController::class, 'index']);
    Route::post('messages',         [MessageController::class, 'store']);
    Route::post('messages/upload',  [MessageController::class, 'upload']);
    Route::get('messages/bot',      [MessageController::class, 'botHistory']);
    Route::post('messages/bot',     [MessageController::class, 'bot']);
});
