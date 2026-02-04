<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ContactPeopleController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ExpoCompanyController;
use App\Http\Controllers\ExpoController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\GuideLineController;
use App\Http\Controllers\InventoryLogController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LogoCompanyController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PageSectionController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RefController;
use App\Http\Controllers\ReturnInvoiceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TermsConditionController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::post('application-form', [UserController::class, 'applicationForm']);
Route::post('/log/index', [UserController::class, 'logIndex']);
Route::get('/user-total-count-country', [UserController::class, 'totalCountPerCountry']);

//////////////////////////////////////// user ////////////////////////////////

Route::middleware(['admin'])->group(function () {
    Route::post('/user/index', [UserController::class, 'index']);
    Route::post('user/restore', [UserController::class, 'restore']);
    Route::delete('user/delete', [UserController::class, 'destroy']);
    Route::put('/user/{id}/{column}', [UserController::class, 'toggle']);
    Route::delete('user/force-delete', [UserController::class, 'forceDelete']);
    Route::apiResource('user', UserController::class);
});


Route::get('/get-user-public', [UserController::class, 'indexPublic']);
Route::get('/get-user-active', [UserController::class, 'indexActive']);

//////////////////////////////////////// user ////////////////////////////////

////////////////////////////////////////// Admin ////////////////////////////////
Route::middleware(['admin'])->group(function () {
    Route::post('/admin/index', [AdminController::class, 'index']);
    Route::post('admin/restore', [AdminController::class, 'restore']);
    Route::delete('admin/delete', [AdminController::class, 'destroy']);
    Route::delete('admin/force-delete', [AdminController::class, 'forceDelete']);
    Route::put('/admin/{id}/{column}', [AdminController::class, 'toggle']);
    Route::post('/admin-select', [AdminController::class, 'index']);
    Route::post('/admin-logout', [AdminController::class, 'logout']);
    Route::get('/get-admin', [AdminController::class, 'getCurrentAdmin']);
    });
    Route::apiResource('admin', AdminController::class);
Route::post('/admin/login', [AdminController::class, 'login']);
////////////////////////////////////////// Admin ////////////////////////////////
////////////////////////////////////////// Admin ////////////////////////////////

////////////////////////////////////////// media ////////////////////////////////



Route::group(['middleware' => ['api']], static function () {
    Route::get('/media', [MediaController::class, 'index']);
    Route::get('/media/{media}', [MediaController::class, 'show']);
    Route::post('/media', [MediaController::class, 'store']);
    Route::delete('/media/{media}', [MediaController::class, 'destroy']);
    Route::get('/get-unused-media', [MediaController::class, 'getUnUsedImages']);
    Route::delete('/delete-unused-media', [MediaController::class, 'deleteUnUsedImages']);
});
Route::get('/get-media/{media}', [MediaController::class, 'show']);
Route::post('/media-array', [MediaController::class, 'showMedia']);
Route::post('/media-upload-many', [MediaController::class, 'storeMany']);

//////////////////////////////////////// media ////////////////////////////////
//////////////////////////////////////// media ////////////////////////////////



//////////////////////////////////////// branch ////////////////////////////////

Route::middleware(['admin'])->group(function () {
    Route::post('/branch/index', [BranchController::class, 'index']);
    Route::post('branch/restore', [BranchController::class, 'restore']);
    Route::delete('branch/delete', [BranchController::class, 'destroy']);
    Route::put('/branch/{id}/{column}', [BranchController::class, 'toggle']);
    Route::delete('branch/force-delete', [BranchController::class, 'forceDelete']);
    Route::apiResource('branch', BranchController::class);
});
//////////////////////////////////////// branch ////////////////////////////////
//////////////////////////////////////// branch ////////////////////////////////

//////////////////////////////////////// warehouse ////////////////////////////////

Route::middleware(['admin'])->group(function () {
    Route::post('/warehouse/index', [WarehouseController::class, 'index']);
    Route::post('warehouse/restore', [WarehouseController::class, 'restore']);
    Route::delete('warehouse/delete', [WarehouseController::class, 'destroy']);
    Route::put('/warehouse/{id}/{column}', [WarehouseController::class, 'toggle']);
    Route::delete('warehouse/force-delete', [WarehouseController::class, 'forceDelete']);
    Route::apiResource('warehouse', WarehouseController::class);
});
//////////////////////////////////////// warehouse ////////////////////////////////
//////////////////////////////////////// warehouse ////////////////////////////////

Route::get('warehouses/{warehouse}/products', [WarehouseController::class, 'warehouseProducts']);
Route::post('warehouses/transfer', [WarehouseController::class, 'transfer']);
Route::post('warehouses/inventory-store', [WarehouseController::class, 'inventoryStore']);
Route::post('/inventory/index', [InventoryLogController::class, 'index']);
Route::post('/warehouses/index-product', [InventoryLogController::class, 'indexProduct']);

//////////////////////////////////////// color ////////////////////////////////

Route::middleware(['admin'])->group(function () {
    Route::post('/color/index', [ColorController::class, 'index']);
    Route::post('color/restore', [ColorController::class, 'restore']);
    Route::delete('color/delete', [ColorController::class, 'destroy']);
    Route::put('/color/{id}/{column}', [ColorController::class, 'toggle']);
    Route::delete('color/force-delete', [ColorController::class, 'forceDelete']);
    Route::apiResource('color', ColorController::class);
});
//////////////////////////////////////// color ////////////////////////////////
//////////////////////////////////////// color ////////////////////////////////


//////////////////////////////////////// unit ////////////////////////////////

Route::middleware(['admin'])->group(function () {
    Route::post('/unit/index', [UnitController::class, 'index']);
    Route::post('unit/restore', [UnitController::class, 'restore']);
    Route::delete('unit/delete', [UnitController::class, 'destroy']);
    Route::put('/unit/{id}/{column}', [UnitController::class, 'toggle']);
    Route::delete('unit/force-delete', [UnitController::class, 'forceDelete']);
    Route::apiResource('unit', UnitController::class);
});
//////////////////////////////////////// unit ////////////////////////////////
//////////////////////////////////////// unit ////////////////////////////////

//////////////////////////////////////// category ////////////////////////////////

Route::middleware(['admin'])->group(function () {
    Route::post('/category/index', [CategoryController::class, 'index']);
    Route::post('category/restore', [CategoryController::class, 'restore']);
    Route::delete('category/delete', [CategoryController::class, 'destroy']);
    Route::put('/category/{id}/{column}', [CategoryController::class, 'toggle']);
    Route::delete('category/force-delete', [CategoryController::class, 'forceDelete']);
    Route::apiResource('category', CategoryController::class);
});
    Route::get('/index-sub-account', [CategoryController::class, 'indexSubAccount']);

//////////////////////////////////////// category ////////////////////////////////
//////////////////////////////////////// category ////////////////////////////////



//////////////////////////////////////// product ////////////////////////////////

Route::middleware(['admin'])->group(function () {
    Route::post('/product/index', [ProductController::class, 'index']);
    Route::post('product/restore', [ProductController::class, 'restore']);
    Route::delete('product/delete', [ProductController::class, 'destroy']);
    Route::put('/product/{id}/{column}', [ProductController::class, 'toggle']);
    Route::delete('product/force-delete', [ProductController::class, 'forceDelete']);
    Route::apiResource('product', ProductController::class);
});
//////////////////////////////////////// product ////////////////////////////////
//////////////////////////////////////// product ////////////////////////////////




//////////////////////////////////////// offer ////////////////////////////////

Route::middleware(['admin'])->group(function () {
    Route::post('/offer/index', [OfferController::class, 'index']);
    Route::post('offer/restore', [OfferController::class, 'restore']);
    Route::delete('offer/delete', [OfferController::class, 'destroy']);
    Route::put('/offer/{id}/{column}', [OfferController::class, 'toggle']);
    Route::delete('offer/force-delete', [OfferController::class, 'forceDelete']);
    Route::apiResource('offer', OfferController::class);
});
    Route::get('/offer/reports', [OfferController::class, 'reports']);

//////////////////////////////////////// offer ////////////////////////////////
//////////////////////////////////////// offer ////////////////////////////////


//////////////////////////////////////// customer ////////////////////////////////

Route::middleware(['admin'])->group(function () {
    Route::post('/customer/index', [CustomerController::class, 'index']);
    Route::post('customer/restore', [CustomerController::class, 'restore']);
    Route::delete('customer/delete', [CustomerController::class, 'destroy']);
    Route::put('/customer/{id}/{column}', [CustomerController::class, 'toggle']);
    Route::delete('customer/force-delete', [CustomerController::class, 'forceDelete']);
    Route::apiResource('customer', CustomerController::class);
});
//////////////////////////////////////// customer ////////////////////////////////
//////////////////////////////////////// customer ////////////////////////////////

    Route::post('/invoice/store', [InvoiceController::class, 'store']);
    Route::post('/invoice-return/store', [ReturnInvoiceController::class, 'storeReturn']);

//////////////////////////////////////// return ////////////////////////////////
//////////////////////////////////////// return ////////////////////////////////
