<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CashierShiftController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeleveryManController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InventoryLogController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LoyaltySettingController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseInvoiceController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\ReturnInvoiceController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalesInvoiceController;
use App\Http\Controllers\SalesInvoiceReturnController;
use App\Http\Controllers\SalesRepresentativeController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
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

Route::middleware(['auth:sanctum'])->group(function () {
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
Route::middleware(['auth:sanctum'])->group(function () {
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

Route::middleware(['auth:sanctum'])->group(function () {
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

Route::middleware(['auth:sanctum'])->group(function () {
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

Route::middleware(['auth:sanctum'])->group(function () {
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

Route::middleware(['auth:sanctum'])->group(function () {
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

Route::middleware(['auth:sanctum'])->group(function () {
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

Route::middleware(['auth:sanctum'])->group(function () {
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

Route::middleware(['auth:sanctum'])->group(function () {
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/customer/index', [CustomerController::class, 'index']);
    Route::post('customer/restore', [CustomerController::class, 'restore']);
    Route::delete('customer/delete', [CustomerController::class, 'destroy']);
    Route::put('/customer/{id}/{column}', [CustomerController::class, 'toggle']);
    Route::delete('customer/force-delete', [CustomerController::class, 'forceDelete']);
    Route::apiResource('customer', CustomerController::class);
});
//////////////////////////////////////// customer ////////////////////////////////
//////////////////////////////////////// customer ////////////////////////////////

//////////////////////////////////////// invoice ////////////////////////////////
//////////////////////////////////////// invoice ////////////////////////////////

    Route::post('/invoice/store', [InvoiceController::class, 'store']);
    Route::post('/invoice-return/store', [ReturnInvoiceController::class, 'storeReturn']);
    Route::get('/invoices/search', [InvoiceController::class, 'searchByInvoiceNumber']);
    Route::post('/invoices/index', [InvoiceController::class, 'invoiceIndex']);
    Route::post('/return-invoices/index', [ReturnInvoiceController::class, 'invoiceReturnIndex']);
    Route::get('products/search', [ProductController::class, 'searchByProductName']);

//////////////////////////////////////// invoice ////////////////////////////////
//////////////////////////////////////// invoice ////////////////////////////////





//////////////////////////////////////// Employee ////////////////////////////////

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/employee/index', [EmployeeController::class, 'index']);
    Route::post('employee/restore', [EmployeeController::class, 'restore']);
    Route::delete('employee/delete', [EmployeeController::class, 'destroy']);
    Route::put('/employee/{id}/{column}', [EmployeeController::class, 'toggle']);
    Route::delete('employee/force-delete', [EmployeeController::class, 'forceDelete']);
    Route::apiResource('employee', EmployeeController::class);
});
//////////////////////////////////////// Employee ////////////////////////////////
//////////////////////////////////////// Employee ////////////////////////////////



//////////////////////////////////////// SalesRepresentative ////////////////////////////////

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/sales-representative/index', [SalesRepresentativeController::class, 'index']);
    Route::post('sales-representative/restore', [SalesRepresentativeController::class, 'restore']);
    Route::delete('sales-representative/delete', [SalesRepresentativeController::class, 'destroy']);
    Route::put('/sales-representative/{id}/{column}', [SalesRepresentativeController::class, 'toggle']);
    Route::delete('sales-representative/force-delete', [SalesRepresentativeController::class, 'forceDelete']);
    Route::apiResource('sales-representative', SalesRepresentativeController::class);
});
//////////////////////////////////////// SalesRepresentative ////////////////////////////////
//////////////////////////////////////// SalesRepresentative ////////////////////////////////



//////////////////////////////////////// DeleveryMan ////////////////////////////////

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/delevery-man/index', [DeleveryManController::class, 'index']);
    Route::post('delevery-man/restore', [DeleveryManController::class, 'restore']);
    Route::delete('delevery-man/delete', [DeleveryManController::class, 'destroy']);
    Route::put('/delevery-man/{id}/{column}', [DeleveryManController::class, 'toggle']);
    Route::delete('delevery-man/force-delete', [DeleveryManController::class, 'forceDelete']);
    Route::apiResource('delevery-man', DeleveryManController::class);
});
//////////////////////////////////////// DeleveryMan ////////////////////////////////
//////////////////////////////////////// DeleveryMan ////////////////////////////////


//////////////////////////////////////// Attendance ////////////////////////////////

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/attendance/index', [AttendanceController::class, 'index']);
    Route::post('attendance/restore', [AttendanceController::class, 'restore']);
    Route::delete('attendance/delete', [AttendanceController::class, 'destroy']);
    Route::put('/attendance/{id}/{column}', [AttendanceController::class, 'toggle']);
    Route::delete('attendance/force-delete', [AttendanceController::class, 'forceDelete']);
    Route::apiResource('attendance', AttendanceController::class);
});
Route::post('/attendance/import', [AttendanceController::class, 'importAttendance']);

//////////////////////////////////////// Attendance ////////////////////////////////
//////////////////////////////////////// Attendance ////////////////////////////////



//////////////////////////////////////// LoyaltySetting ////////////////////////////////
//////////////////////////////////////// LoyaltySetting ////////////////////////////////

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/loyalty-points/index', [LoyaltySettingController::class, 'index']);
    Route::post('/loyalty-points/restore', [LoyaltySettingController::class, 'restore']); // لو عايز soft delete
    Route::delete('/loyalty-points/delete', [LoyaltySettingController::class, 'destroy']);
    Route::put('/loyalty-points/{id}/{level}', [LoyaltySettingController::class, 'toggleLevel']);
    Route::apiResource('loyalty-points', LoyaltySettingController::class);
});
//////////////////////////////////////// LoyaltySetting ////////////////////////////////
//////////////////////////////////////// LoyaltySetting ////////////////////////////////



//////////////////////////////////////// Currency ////////////////////////////////
//////////////////////////////////////// Currency ////////////////////////////////

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/currency/index', [CurrencyController::class, 'index']);
    Route::post('/currency/restore', [CurrencyController::class, 'restore']); // لو عايز soft delete
    Route::delete('/currency/delete', [CurrencyController::class, 'destroy']);
    Route::put('/currency/{id}/{column}', [CurrencyController::class, 'toggle']);
    Route::apiResource('currency', CurrencyController::class);
});
//////////////////////////////////////// Currency ////////////////////////////////
//////////////////////////////////////// Currency ////////////////////////////////



//////////////////////////////////////// tax ////////////////////////////////
//////////////////////////////////////// tax ////////////////////////////////

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/tax/index', [TaxController::class, 'index']);
    Route::post('/tax/restore', [TaxController::class, 'restore']); // لو عايز soft delete
    Route::delete('/tax/delete', [TaxController::class, 'destroy']);
    Route::put('/tax/{id}/{column}', [TaxController::class, 'toggle']);
    Route::apiResource('tax', TaxController::class);
});
//////////////////////////////////////// tax ////////////////////////////////
//////////////////////////////////////// tax ////////////////////////////////





//////////////////////////////////////// SalesInvoice ////////////////////////////////
//////////////////////////////////////// SalesInvoice ////////////////////////////////
    Route::post('/sales-invoice/store', [SalesInvoiceController::class, 'store']);
    Route::post('/sales-invoices/index', [SalesInvoiceController::class, 'invoiceIndex']);
    Route::get('/sales-invoices/{id}', [SalesInvoiceController::class, 'show']);
    Route::post('/sales-invoice-return/store', [SalesInvoiceReturnController::class, 'storeReturn']);
    Route::post('/sales-return/index', [SalesInvoiceReturnController::class, 'index']);
    Route::get('/sales-return/{id}', [SalesInvoiceReturnController::class, 'show']);

//////////////////////////////////////// SalesInvoice ////////////////////////////////
//////////////////////////////////////// SalesInvoice ////////////////////////////////



//////////////////////////////////////// suppliers ////////////////////////////////
//////////////////////////////////////// suppliers ////////////////////////////////
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/suppliers/index', [SuppliersController::class, 'index']);
    Route::post('/suppliers/restore', [SuppliersController::class, 'restore']);
    Route::delete('/suppliers/delete', [SuppliersController::class, 'destroy']);
    Route::put('/suppliers/{id}/{column}', [SuppliersController::class, 'toggle']);
    Route::apiResource('suppliers', SuppliersController::class);
});
//////////////////////////////////////// suppliers ////////////////////////////////
//////////////////////////////////////// suppliers ////////////////////////////////


//////////////////////////////////////// purchases-orders ////////////////////////////////
//////////////////////////////////////// purchases-orders ////////////////////////////////
    Route::post('/purchases-orders/store', [PurchaseOrderController::class, 'store']);
    Route::post('/purchases-orders/index', [PurchaseOrderController::class, 'index']);
    Route::get('/purchases-orders/{id}', [PurchaseOrderController::class, 'show']);
//////////////////////////////////////// purchases-orders ////////////////////////////////
//////////////////////////////////////// purchases-orders ////////////////////////////////



//////////////////////////////////////// purchases-invoices ////////////////////////////////
//////////////////////////////////////// purchases-invoices ////////////////////////////////
    Route::post('/purchases-invoices/store', [PurchaseInvoiceController::class, 'store']);
    Route::post('/purchases-invoices/index', [PurchaseInvoiceController::class, 'index']);
    Route::get('/purchases-invoices/{id}', [PurchaseInvoiceController::class, 'show']);
//////////////////////////////////////// purchases-invoices ////////////////////////////////
//////////////////////////////////////// purchases-invoices ////////////////////////////////



/////////////////////////////////////// purchases-returns ////////////////////////////////
//////////////////////////////////////// purchases-returns ////////////////////////////////

Route::post('/purchase-returns/store', [PurchaseReturnController::class, 'store']);
Route::post('/purchase-returns/index', [PurchaseReturnController::class, 'index']);
Route::get('/purchase-returns/{id}', [PurchaseReturnController::class, 'show']);

/////////////////////////////////////// purchases-returns ////////////////////////////////
//////////////////////////////////////// purchases-returns ////////////////////////////////






//////////////////////////////////////// role ////////////////////////////////
//////////////////////////////////////// role ////////////////////////////////
   Route::post('/role/index', [RoleController::class, 'index']);
    Route::post('role/restore', [RoleController::class, 'restore']);
    Route::delete('role/delete', [RoleController::class, 'destroy']);
    Route::put('/role/{id}/{column}', [RoleController::class, 'toggle']);
    Route::delete('role/force-delete', [RoleController::class, 'forceDelete']);
    Route::apiResource('role', RoleController::class);
//////////////////////////////////////// role ////////////////////////////////
//////////////////////////////////////// role ////////////////////////////////

//////////////////////////////////////// shifts ////////////////////////////////
//////////////////////////////////////// shifts ////////////////////////////////


Route::middleware('auth:sanctum')->group(function () {
    Route::get('shifts', [CashierShiftController::class, 'index']);
    Route::get('shifts/current', [CashierShiftController::class, 'getCurrentShift']);
    Route::get('shifts/{shift}', [CashierShiftController::class, 'show']);
    Route::post('shifts/open', [CashierShiftController::class, 'openShift']);
    Route::post('shifts/close', [CashierShiftController::class, 'closeShift']);
});

//////////////////////////////////////// shifts ////////////////////////////////
//////////////////////////////////////// shifts ////////////////////////////////





//////////////////////////////////////// Revenue ////////////////////////////////
//////////////////////////////////////// Revenue ////////////////////////////////

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/revenue/index', [RevenueController::class, 'index']);
    Route::post('revenue/restore', [RevenueController::class, 'restore']);
    Route::delete('revenue/delete', [RevenueController::class, 'destroy']);
    Route::put('/revenue/{id}/{column}', [RevenueController::class, 'toggle']);
    Route::delete('revenue/force-delete', [RevenueController::class, 'forceDelete']);
    Route::apiResource('revenues', RevenueController::class);
});

//////////////////////////////////////// Revenue ////////////////////////////////
//////////////////////////////////////// Revenue ////////////////////////////////

