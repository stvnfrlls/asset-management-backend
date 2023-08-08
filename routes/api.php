<?php

use App\Http\Controllers\Api\AssetTypeController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ClassificationsController;
use App\Http\Controllers\Api\ManufacturerController;
use App\Http\Controllers\Api\UserController;

use App\Http\Controllers\Api\LicensingController;
use App\Http\Controllers\Api\TransferListController;
use App\Http\Controllers\Api\AssetDetailsController;
use App\Http\Controllers\Api\ComponentsController;
use App\Http\Controllers\Api\DepartmentsController;
use App\Http\Controllers\Api\DeviceSpecsController;
use App\Http\Controllers\Api\DisposalController;
use App\Http\Controllers\Api\DisposalMethodController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\LicenseStatusController;
use App\Http\Controllers\Api\LocationDetailsController;
use App\Http\Controllers\Api\PurchasesController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\SoftwareCategoryController;
use App\Http\Controllers\Api\StatusTypeController;
use App\Http\Controllers\Api\UserRolesController;
use App\Http\Controllers\Api\AuditLogsController;
use App\Http\Controllers\Api\UploadController;

use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    // Route for user login, accepting both GET and POST requests and handled by 'loginUser' method in 'UserController'
    Route::match(['GET', 'POST'], 'login', [UserController::class, 'loginUser'])->name('login');

    // Route to get asset types, handled by 'index' method in 'AssetTypeController'
    Route::get('getAssetType', [AssetTypeController::class, 'index']);

    // Route to get categories, handled by 'index' method in 'CategoryController'
    Route::get('getCategories', [CategoryController::class, 'index']);

    // Route to get classifications, handled by 'index' method in 'ClassificationsController'
    Route::get('getClassifications', [ClassificationsController::class, 'index']);

    // Route to get departments, handled by 'index' method in 'DepartmentsController'
    Route::get('getDepartments', [DepartmentsController::class, 'index']);

    // Route to get disposal methods, handled by 'index' method in 'DisposalMethodController'
    Route::get('getDisposalMethod', [DisposalMethodController::class, 'index']);

    // Route to get license statuses, handled by 'index' method in 'LicenseStatusController'
    Route::get('getLicensesStatus', [LicenseStatusController::class, 'index']);

    // Route to get manufacturers, handled by 'index' method in 'ManufacturerController'
    Route::get('getManufacturers', [ManufacturerController::class, 'index']);

    // Route to get software categories, handled by 'index' method in 'SoftwareCategoryController'
    Route::get('getSoftwareCategory', [SoftwareCategoryController::class, 'index']);

    // Route to get status types, handled by 'index' method in 'StatusTypeController'
    Route::get('getStatusType', [StatusTypeController::class, 'index']);

    // Route to get user roles, handled by 'index' method in 'UserRolesController'
    Route::get('getUserRoles', [UserRolesController::class, 'index']);

    // Route to verify upload, handled by 'verifyUpload' method in 'SearchController'
    Route::get('verifyUpload', [SearchController::class, 'verifyUpload']);
});


Route::middleware('auth:api')->group(function () {
    // Asset Details routes
    Route::get('assets', [AssetDetailsController::class, 'index']);
    Route::get('assets/{id}', [AssetDetailsController::class, 'show']);
    Route::post('addAsset', [AssetDetailsController::class, 'store']);
    Route::post('updateAsset/{id}', [AssetDetailsController::class, 'update']);

    // Asset Type routes
    Route::post('AssetType', [AssetTypeController::class, 'store']);
    Route::post('AssetType/{id}', [AssetTypeController::class, 'update']);
    Route::post('DeleteAssetType/{id}', [AssetTypeController::class, 'delete']);

    // Audit Logs routes
    Route::get('auditlogs', [AuditLogsController::class, 'index']);
    Route::post('auditlogs', [AuditLogsController::class, 'store']);

    // Category routes
    Route::post('Category', [CategoryController::class, 'store']);
    Route::post('Category/{id}', [CategoryController::class, 'update']);
    Route::post('DeleteCategory/{id}', [CategoryController::class, 'delete']);

    // Classifications routes
    Route::post('Classification', [ClassificationsController::class, 'store']);
    Route::post('Classification/{id}', [ClassificationsController::class, 'update']);
    Route::post('DeleteClassification/{id}', [ClassificationsController::class, 'delete']);

    // Components routes
    Route::get('components', [ComponentsController::class, 'index']);
    Route::get('components/{id}', [ComponentsController::class, 'show']);
    Route::post('addComponents', [ComponentsController::class, 'store']);
    Route::post('updateComponents/{id}', [ComponentsController::class, 'update']);

    // Dashboard routes
    Route::get('dashboardData', [SearchController::class, 'dashboardData']);

    // Department routes
    Route::post('Department', [DepartmentsController::class, 'store']);
    Route::post('Department/{id}', [DepartmentsController::class, 'update']);
    Route::post('DeleteDepartment/{id}', [DepartmentsController::class, 'delete']);

    // Device Specs routes
    Route::get('devspec', [DeviceSpecsController::class, 'index']);
    Route::get('devspec/{id}', [DeviceSpecsController::class, 'show']);
    Route::post('addDevspec', [DeviceSpecsController::class, 'store']);
    Route::post('updateDevspec/{id}', [DeviceSpecsController::class, 'update']);

    // Disposal routes
    Route::get('disposed', [DisposalController::class, 'index']);
    Route::get('disposed/{id}', [DisposalController::class, 'show']);
    Route::post('dispose', [DisposalController::class, 'store']);

    // Disposal Method routes
    Route::post('DisposalMethod', [DisposalMethodController::class, 'store']);
    Route::post('DisposalMethod/{id}', [DisposalMethodController::class, 'update']);
    Route::post('DeleteDisposalMethod/{id}', [DisposalMethodController::class, 'delete']);

    // Licensing routes
    Route::get('licenses', [LicensingController::class, 'index']);
    Route::get('licenses/{id}', [LicensingController::class, 'show']);
    Route::post('addLicenses', [LicensingController::class, 'store']);
    Route::post('deleteLicense/{id}', [LicensingController::class, 'delete']);
    Route::post('updateLicenses/{id}', [LicensingController::class, 'update']);
    Route::get('availableOS', [LicensingController::class, 'availableOperatingSystem']);

    // Location Details routes
    Route::get('location', [LocationDetailsController::class, 'index']);
    Route::get('location/{id}', [LocationDetailsController::class, 'show']);
    Route::post('addLocation', [LocationDetailsController::class, 'store']);
    Route::post('updateLocation/{id}', [LocationDetailsController::class, 'update']);

    // Logs routes
    Route::get('logs', [TransferListController::class, 'index']);
    Route::get('logs/{id}', [TransferListController::class, 'show']);
    Route::post('transfer', [TransferListController::class, 'store']);

    // Manufacturer routes
    Route::post('Manufacturer', [ManufacturerController::class, 'store']);
    Route::post('Manufacturer/{id}', [ManufacturerController::class, 'update']);
    Route::post('DeleteManufacturer/{id}', [ManufacturerController::class, 'delete']);

    // Purchases routes
    Route::get('purchases', [PurchasesController::class, 'index']);
    Route::get('purchases/{id}', [PurchasesController::class, 'show']);
    Route::post('addPurchases', [PurchasesController::class, 'store']);
    Route::post('updatePurchases/{id}', [PurchasesController::class, 'update']);

    // Search routes
    Route::get('getAll', [SearchController::class, 'getAll']);
    Route::get('getAllDetails', [SearchController::class, 'getAllDetails']);
    Route::get('getDevice', [SearchController::class, 'getAllDevice']);
    Route::get('getData', [InventoryController::class, 'getinventoryData']);
    Route::get('getDeviceAssetNo', [SearchController::class, 'getDeviceAssetNo']);
    Route::get('getAssetNo', [SearchController::class, 'getAssetNo']);
    Route::get('getAssetList', [SearchController::class, 'getAssetList']);
    Route::get('availableOffice', [SearchController::class, 'availableOffice']);
    Route::get('getAssetsWithDeviceSpecs', [SearchController::class, 'getAssetsWithDeviceSpecs']);
    Route::get('getDisposedAssets', [SearchController::class, 'getDisposedAssets']);

    // Software Category routes
    Route::post('SoftwareCategory', [SoftwareCategoryController::class, 'store']);
    Route::post('SoftwareCategory/{id}', [SoftwareCategoryController::class, 'update']);
    Route::post('DeleteSoftwareCategory/{id}', [SoftwareCategoryController::class, 'delete']);

    // Status Type routes
    Route::post('StatusType', [StatusTypeController::class, 'store']);
    Route::post('StatusType/{id}', [StatusTypeController::class, 'update']);
    Route::post('DeleteStatusType/{id}', [StatusTypeController::class, 'delete']);

    // Transfer List routes
    Route::get('logs', [TransferListController::class, 'index']);
    Route::get('logs/{id}', [TransferListController::class, 'show']);
    Route::post('transfer', [TransferListController::class, 'store']);

    // Upload route
    Route::post('upload', [UploadController::class, 'store']);

    // User routes
    Route::get('user', [UserController::class, 'getUserDetails']);
    Route::get('getUserList', [UserController::class, 'getUsers']);
    Route::get('logout', [UserController::class, 'userLogout']);
    Route::post('register', [UserController::class, 'registerAccount']);
    Route::post('updatePassword/{id}', [UserController::class, 'updatePassword']);
    Route::post('delete/{id}', [UserController::class, 'deleteAccount']);

    // User Role routes
    Route::post('UserRole', [UserRolesController::class, 'store']);
    Route::post('UserRole/{id}', [UserRolesController::class, 'update']);
    Route::post('DeleteUserRole/{id}', [UserRolesController::class, 'delete']);
});
