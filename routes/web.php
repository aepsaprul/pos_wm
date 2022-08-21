<?php

use App\Http\Controllers\AngsuranController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InventoryCashierController;
use App\Http\Controllers\InventoryInvoiceController;
use App\Http\Controllers\InventroryProductInController;
use App\Http\Controllers\InventroryProductOutController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NavController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductShopController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ReceiveProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ShopBuyController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    // dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('dashboard/{id}/show', [DashboardController::class, 'show'])->name('dashboard.show');
    Route::get('dashboard/shop', [DashboardController::class, 'shop'])->name('dashboard.shop');
    Route::get('dashboard/{id}/shop_show', [DashboardController::class, 'shopShow'])->name('dashboard.shop_show');

    // ubah password
    Route::get('change-password', [ChangePasswordController::class, 'index'])->name('change.password.index');
    Route::post('change-password', [ChangePasswordController::class, 'store'])->name('change.password');

    // master

        // employee
        Route::get('master/employee', [EmployeeController::class, 'index'])->name('employee.index');
        Route::get('master/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::post('master/employee/store', [EmployeeController::class, 'store'])->name('employee.store');
        Route::get('master/employee/{id}/show', [EmployeeController::class, 'show'])->name('employee.show');
        Route::get('master/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::post('master/employee/update', [EmployeeController::class, 'update'])->name('employee.update');
        Route::get('master/employee/{id}/delete_btn', [EmployeeController::class, 'deleteBtn'])->name('employee.delete_btn');
        Route::post('master/employee/delete', [EmployeeController::class, 'delete'])->name('employee.delete');
        Route::get('master/employee/{id}/akses', [EmployeeController::class, 'akses'])->name('employee.akses');
        Route::post('master/employee/akses_store', [EmployeeController::class, 'aksesStore'])->name('employee.akses_store');

        // position
        Route::get('master/position', [PositionController::class, 'index'])->name('position.index');
        Route::post('master/position/store', [PositionController::class, 'store'])->name('position.store');
        Route::get('master/position/{id}/edit', [PositionController::class, 'edit'])->name('position.edit');
        Route::post('master/position/update', [PositionController::class, 'update'])->name('position.update');
        Route::get('master/position/{id}/delete_btn', [PositionController::class, 'deleteBtn'])->name('position.delete_btn');
        Route::post('master/position/delete', [PositionController::class, 'delete'])->name('position.delete');

        // navigasi
        Route::get('master/nav', [NavController::class, 'index'])->name('nav.index');

            // navigasi main
            Route::post('master/nav/main_store', [NavController::class, 'mainStore'])->name('nav.main_store');
            Route::get('master/nav/{id}/main_edit', [NavController::class, 'mainEdit'])->name('nav.main_edit');
            Route::post('master/nav/main_update', [NavController::class, 'mainUpdate'])->name('nav.main_update');
            Route::get('master/nav/{id}/main_delete_btn', [NavController::class, 'mainDeleteBtn'])->name('nav.main_delete_btn');
            Route::post('master/nav/main_delete', [NavController::class, 'mainDelete'])->name('nav.main_delete');

            // navigasi sub
            Route::get('master/nav/sub_create', [NavController::class, 'subCreate'])->name('nav.sub_create');
            Route::post('master/nav/sub_store', [NavController::class, 'subStore'])->name('nav.sub_store');
            Route::get('master/nav/{id}/sub_edit', [NavController::class, 'subEdit'])->name('nav.sub_edit');
            Route::post('master/nav/sub_update', [NavController::class, 'subUpdate'])->name('nav.sub_update');
            Route::get('master/nav/{id}/sub_delete_btn', [NavController::class, 'subDeleteBtn'])->name('nav.sub_delete_btn');
            Route::post('master/nav/sub_delete', [NavController::class, 'subDelete'])->name('nav.sub_delete');

            // navigasi tombol
            Route::get('master/nav/tombol_create', [NavController::class, 'tombolCreate'])->name('nav.tombol_create');
            Route::post('master/nav/tombol_store', [NavController::class, 'tombolStore'])->name('nav.tombol_store');
            Route::get('master/nav/{id}/tombol_edit', [NavController::class, 'tombolEdit'])->name('nav.tombol_edit');
            Route::post('master/nav/tombol_update', [NavController::class, 'tombolUpdate'])->name('nav.tombol_update');
            Route::get('master/nav/{id}/tombol_delete_btn', [NavController::class, 'tombolDeleteBtn'])->name('nav.tombol_delete_btn');
            Route::post('master/nav/tombol_delete', [NavController::class, 'tombolDelete'])->name('nav.tombol_delete');

        // roles
        Route::get('master/roles', [RolesController::class, 'index'])->name('roles.index');
        Route::post('master/roles/store', [RolesController::class, 'store'])->name('roles.store');
        Route::get('master/roles/{id}/edit', [RolesController::class, 'edit'])->name('roles.edit');
        Route::post('master/roles/update', [RolesController::class, 'update'])->name('roles.update');
        Route::get('master/roles/{id}/delete_btn', [RolesController::class, 'deleteBtn'])->name('roles.delete_btn');
        Route::post('master/roles/delete', [RolesController::class, 'delete'])->name('roles.delete');
        Route::get('master/roles/{id}/access', [RolesController::class, 'access'])->name('roles.access');
        Route::post('master/roles/access_save', [RolesController::class, 'accessSave'])->name('roles.access_save');

        // user
        Route::get('master/user', [UserController::class, 'index'])->name('user.index');
        Route::get('master/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('master/user/store', [UserController::class, 'store'])->name('user.store');
        Route::get('master/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::post('master/user/update', [UserController::class, 'update'])->name('user.update');
        Route::get('master/user/{id}/delete_btn', [UserController::class, 'deleteBtn'])->name('user.delete_btn');
        Route::post('master/user/delete', [UserController::class, 'delete'])->name('user.delete');
        Route::get('master/user/{id}/access', [UserController::class, 'access'])->name('user.access');
        Route::put('master/user/{id}/access_save', [UserController::class, 'accessSave'])->name('user.access_save');
        Route::post('master/user/sync', [UserController::class, 'sync'])->name('user.sync');

        // product category
        Route::get('master/product_category', [ProductCategoryController::class, 'index'])->name('product_category.index');
        Route::post('master/product_category/store', [ProductCategoryController::class, 'store'])->name('product_category.store');
        Route::post('master/product_category/update', [ProductCategoryController::class, 'update'])->name('product_category.update');
        Route::get('master/product_category/{id}/edit', [ProductCategoryController::class, 'edit'])->name('product_category.edit');
        Route::get('master/product_category/{id}/delete_btn', [ProductCategoryController::class, 'deleteBtn'])->name('product_category.delete_btn');
        Route::post('master/product_category/delete', [ProductCategoryController::class, 'delete'])->name('product_category.delete');

        // product
        Route::get('master/product', [ProductController::class, 'index'])->name('product.index');
        Route::get('master/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('master/product/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('master/product/{id}/show', [ProductController::class, 'show'])->name('product.show');
        Route::post('master/product/update', [ProductController::class, 'update'])->name('product.update');
        Route::get('master/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::get('master/product/{id}/delete_btn', [ProductController::class, 'deleteBtn'])->name('product.delete_btn');
        Route::post('master/product/delete', [ProductController::class, 'delete'])->name('product.delete');
        Route::post('master/product/product_master_store', [ProductController::class, 'productMasterStore'])->name('product.product_master_store');
        Route::post('master/product/product_category_store', [ProductController::class, 'productCategoryStore'])->name('product.product_category_store');
        Route::get('master/product/{id}/remove', [ProductController::class, 'remove'])->name('product.remove');
        Route::post('master/product/add_parameter', [ProductController::class, 'addParameter'])->name('product.add_parameter');
        Route::get('master/product/{id}/barcode', [ProductController::class, 'barcode'])->name('product.barcode');
        Route::post('master/product/barcode_print', [ProductController::class, 'barcodePrint'])->name('product.barcode_print');
        Route::get('master/product/{id}/barcode_print_template', [ProductController::class, 'barcodePrintTemplate'])->name('product.barcode_print_template');

        // shop
        Route::get('master/shop', [ShopController::class, 'index'])->name('shop.index');
        Route::post('master/shop/store', [ShopController::class, 'store'])->name('shop.store');
        Route::post('master/shop/update', [ShopController::class, 'update'])->name('shop.update');
        Route::get('master/shop/{id}/edit', [ShopController::class, 'edit'])->name('shop.edit');
        Route::get('master/shop/{id}/delete_btn', [ShopController::class, 'deleteBtn'])->name('shop.delete_btn');
        Route::post('master/shop/delete', [ShopController::class, 'delete'])->name('shop.delete');

    // transaction inventory

        // product in
        Route::get('inventory_transaction/product_in', [InventroryProductInController::class, 'index'])->name('product_in.index');
        Route::get('inventory_transaction/product_in/create', [InventroryProductInController::class, 'create'])->name('product_in.create');
        Route::post('inventory_transaction/product_in/store', [InventroryProductInController::class, 'store'])->name('product_in.store');
        Route::post('inventory_transaction/product_in/update', [InventroryProductInController::class, 'update'])->name('product_in.update');
        Route::get('inventory_transaction/product_in/{id}/edit', [InventroryProductInController::class, 'edit'])->name('product_in.edit');
        Route::get('inventory_transaction/product_in/{id}/delete_btn', [InventroryProductInController::class, 'deleteBtn'])->name('product_in.delete_btn');
        Route::post('inventory_transaction/product_in/delete', [InventroryProductInController::class, 'delete'])->name('product_in.delete');

        // product out
        Route::get('inventory_transaction/product_out', [InventroryProductOutController::class, 'index'])->name('product_out.index');
        Route::get('inventory_transaction/product_out/create', [InventroryProductOutController::class, 'create'])->name('product_out.create');
        Route::post('inventory_transaction/product_out/store', [InventroryProductOutController::class, 'store'])->name('product_out.store');
        Route::post('inventory_transaction/product_out/update', [InventroryProductOutController::class, 'update'])->name('product_out.update');
        Route::get('inventory_transaction/product_out/{id}/edit', [InventroryProductOutController::class, 'edit'])->name('product_out.edit');
        Route::get('inventory_transaction/product_out/{id}/delete_btn', [InventroryProductOutController::class, 'deleteBtn'])->name('product_out.delete_btn');
        Route::post('inventory_transaction/product_out/delete', [InventroryProductOutController::class, 'delete'])->name('product_out.delete');

        // inventory invoice
        Route::get('inventory_transaction/inventory_invoice', [InventoryInvoiceController::class, 'index'])->name('inventory_invoice.index');
        Route::get('inventory_transaction/inventory_invoice/{id}/show', [InventoryInvoiceController::class, 'show'])->name('inventory_invoice.show');
        Route::get('inventory_transaction/inventory_invoice/{id}/delete_btn', [InventoryInvoiceController::class, 'deleteBtn'])->name('inventory_invoice.delete_btn');
        Route::post('inventory_transaction/inventory_invoice/delete', [InventoryInvoiceController::class, 'delete'])->name('inventory_invoice.delete');
        Route::get('inventory_transaction/inventory_invoice/{id}/print', [InventoryInvoiceController::class, 'print'])->name('inventory_invoice.print');
        Route::get('inventory_transaction/inventory_invoice/{id}/unpaid', [InventoryInvoiceController::class, 'unpaid'])->name('inventory_invoice.unpaid');
        Route::get('inventory_transaction/inventory_invoice/{id}/cancel', [InventoryInvoiceController::class, 'cancel'])->name('inventory_invoice.cancel');

        // inventory cashier
        Route::get('inventory_cashier', [InventoryCashierController::class, 'index'])->name('inventory_cashier.index');
        Route::post('inventory_cashier/product', [InventoryCashierController::class, 'getProduct'])->name('inventory_cashier.product');
        Route::post('inventory_cashier/product-out-save', [InventoryCashierController::class, 'productOutSave'])->name('inventory_cashier.product_out_save');
        Route::delete('inventory_cashier/{id}/delete', [InventoryCashierController::class, 'delete'])->name('inventory_cashier.delete');
        Route::post('inventory_cashier/print', [InventoryCashierController::class, 'print'])->name('inventory_cashier.print');
        Route::get('inventory_cashier/{id}/print_result', [InventoryCashierController::class, 'printResult'])->name('inventory_cashier.print_result');

    // supplier
    Route::get('supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::post('supplier/update', [SupplierController::class, 'update'])->name('supplier.update');
    Route::get('supplier/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::get('supplier/{id}/delete_btn', [SupplierController::class, 'deleteBtn'])->name('supplier.delete_btn');
    Route::post('supplier/delete', [SupplierController::class, 'delete'])->name('supplier.delete');

    // promo
    Route::get('promo', [PromoController::class, 'index'])->name('promo.index');
    Route::post('promo/store', [PromoController::class, 'store'])->name('promo.store');
    Route::put('promo/{id}/update', [PromoController::class, 'update'])->name('promo.update');
    Route::get('promo/{id}/edit', [PromoController::class, 'edit'])->name('promo.edit');
    Route::get('promo/{id}/delete_btn', [PromoController::class, 'deleteBtn'])->name('promo.delete_btn');
    Route::post('promo/delete', [PromoController::class, 'delete'])->name('promo.delete');
    Route::put('promo/{id}/publish', [PromoController::class, 'publish'])->name('promo.publish');
    Route::get('promo/{id}/add_product', [PromoController::class, 'addProduct'])->name('promo.add_product');
    Route::post('promo/add_product_save', [PromoController::class, 'addProductSave'])->name('promo.add_product_save');
    Route::get('promo/{id}/delete_promo_product', [PromoController::class, 'deletePromoProduct'])->name('promo.delete_promo_product');

    // report
        // sales
        Route::get('report', [ReportController::class, 'index'])->name('report.index');
        Route::get('repost/{id}/sales_shop', [ReportController::class, 'salesShop'])->name('report.sales_shop');
        Route::post('report/sales_search', [ReportController::class, 'salesSearch'])->name('report.sales_search');
        Route::get('report/sales_get_data_current', [ReportController::class, 'salesGetDataCurrent'])->name('report.sales_get_data_current');
        Route::post('report/sales_get_data', [ReportController::class, 'salesGetData'])->name('report.sales_get_data');
        Route::post('report/sales_not_customer', [ReportController::class, 'salesNotCustomer'])->name('report.sales_not_customer');
        Route::post('report/sales_customer', [ReportController::class, 'salesCustomer'])->name('report.sales_customer');

        // customer
        Route::get('report/customer', [ReportController::class, 'customerIndex'])->name('report.customer_index');
        Route::get('report/customer_get_data', [ReportController::class, 'customerGetData'])->name('report.customer_get_data');
        Route::get('report/{id}/customer_detail', [ReportController::class, 'customerDetail'])->name('report.customer_detail');

        // product
        Route::get('report/product', [ReportController::class, 'productIndex'])->name('report.product_index');
        Route::get('report/product_get_data', [ReportController::class, 'productGetData'])->name('report.product_get_data');
        Route::get('report/{id}/product_detail', [ReportController::class, 'productDetail'])->name('report.product_detail');

        // income
        Route::get('report/income', [ReportController::class, 'incomeIndex'])->name('report.income_index');
        Route::get('report/income_get_data', [ReportController::class, 'incomeGetData'])->name('report.income_get_data');
        Route::post('report/income_filter', [ReportController::class, 'incomeFilter'])->name('report.income_filter');

    // product shop
    Route::get('product_shop', [ProductShopController::class, 'index'])->name('product_shop.index');
    Route::get('product_shop/create', [ProductShopController::class, 'create'])->name('product_shop.create');
    Route::post('product_shop/store', [ProductShopController::class, 'store'])->name('product_shop.store');
    Route::post('product_shop/update', [ProductShopController::class, 'update'])->name('product_shop.update');
    Route::get('product_shop/{id}/edit', [ProductShopController::class, 'edit'])->name('product_shop.edit');
    Route::get('product_shop/{id}/delete_btn', [ProductShopController::class, 'deleteBtn'])->name('product_shop.delete_btn');
    Route::post('product_shop/delete', [ProductShopController::class, 'delete'])->name('product_shop.delete');

    // Buy
    Route::get('shop_buy', [ShopBuyController::class, 'index'])->name('shop_buy.index');
    Route::get('shop_buy/{id}/detail', [ShopBuyController::class, 'detail'])->name('shop_buy.detail');
    Route::post('shop_buy/search', [ShopBuyController::class, 'search'])->name('shop_buy.search');
    Route::get('shop_buy/cart', [ShopBuyController::class, 'cart'])->name('shop_buy.cart');
    Route::post('shop_buy/cart/store', [ShopBuyController::class, 'cartStore'])->name('shop_buy.cart.store');
    Route::post('shop_buy/cart/qty', [ShopBuyController::class, 'cartQty'])->name('shop_buy.cart.qty');
    Route::post('shop_buy/cart/delete_all', [ShopBuyController::class, 'cartDeleteAll'])->name('shop_buy.cart.delete_all');
    Route::post('shop_buy/cart/delete', [ShopBuyController::class, 'cartDelete'])->name('shop_buy.cart.delete');
    Route::post('shop_buy/cart/finish', [ShopBuyController::class, 'cartFinish'])->name('shop_buy.cart.finish');
    Route::get('shop_buy/cart/{kode}/invoice', [ShopBuyController::class, 'cartInvoice'])->name('shop_buy.cart.invoice');
    Route::get('shop_buy/cart/{kode}/invoice_print', [ShopBuyController::class, 'cartInvoicePrint'])->name('shop_buy.cart.invoice_print');

    // transaction buy
    Route::get('transaction', [TransactionController::class, 'index'])->name('transaction.index');

    // transaction shop

        // receive product
        Route::get('shop_transaction/received_product', [ReceiveProductController::class, 'index'])->name('received_product.index');
        Route::get('shop_transaction/received_product/create', [ReceiveProductController::class, 'create'])->name('received_product.create');
        Route::post('shop_transaction/received_product/store', [ReceiveProductController::class, 'store'])->name('received_product.store');
        Route::post('shop_transaction/received_product/update', [ReceiveProductController::class, 'update'])->name('received_product.update');
        Route::get('shop_transaction/received_product/{id}/edit', [ReceiveProductController::class, 'edit'])->name('received_product.edit');
        Route::get('shop_transaction/received_product/{id}/delete_btn', [ReceiveProductController::class, 'deleteBtn'])->name('received_product.delete_btn');
        Route::post('shop_transaction/received_product/delete', [ReceiveProductController::class, 'delete'])->name('received_product.delete');

        // sales
        Route::get('shop_transaction/sales', [SalesController::class, 'index'])->name('sales.index');
        Route::get('shop_transaction/sales/{id}/show', [SalesController::class, 'show'])->name('sales.show');
        Route::get('shop_transaction/sales/{id}/delete_btn', [SalesController::class, 'deleteBtn'])->name('sales.delete_btn');
        Route::post('shop_transaction/sales/delete', [SalesController::class, 'delete'])->name('sales.delete');

        // invoice
        Route::get('shop_transaction/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
        Route::get('shop_transaction/invoice/{id}/show', [InvoiceController::class, 'show'])->name('invoice.show');
        Route::get('shop_transaction/invoice/{id}/delete_btn', [InvoiceController::class, 'deleteBtn'])->name('invoice.delete_btn');
        Route::post('shop_transaction/invoice/delete', [InvoiceController::class, 'delete'])->name('invoice.delete');
        Route::get('shop_transaction/{id}/bayar', [InvoiceController::class, 'bayar'])->name('invoice.bayar');
        Route::post('shop_transaction/invoice/bayar_save', [InvoiceController::class, 'bayarSave'])->name('invoice.bayar_save');

    // customer
    Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::post('customer/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::post('customer/update', [CustomerController::class, 'update'])->name('customer.update');
    Route::get('customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::get('customer/{id}/delete_btn', [CustomerController::class, 'deleteBtn'])->name('customer.delete_btn');
    Route::post('customer/delete', [CustomerController::class, 'delete'])->name('customer.delete');

    // cashier
        // cash
        Route::get('cashier', [CashierController::class, 'index'])->name('cashier.index');
        Route::post('cashier/product', [CashierController::class, 'getProduct'])->name('cashier.product');
        Route::post('cashier/sales-save', [CashierController::class, 'salesSave'])->name('cashier.sales_save');
        Route::post('cashier/print', [CashierController::class, 'print'])->name('cashier.print');
        Route::delete('cashier/{id}/delete', [CashierController::class, 'delete'])->name('cashier.delete');
        Route::post('cashier/promo', [CashierController::class, 'promo'])->name('cashier.promo');
        Route::get('cashier/{id}/print_result', [CashierController::class, 'printResult'])->name('cashier.print_result');
        Route::post('cashier/update_promo', [CashierController::class, 'updatePromo'])->name('cashier.update_promo');

        // credit
        Route::get('cashier/credit', [CashierController::class, 'credit'])->name('cashier.credit');

    // angsuran
    Route::get('angsuran', [AngsuranController::class, 'index'])->name('angsuran.index');
    Route::post('angsuran/store', [AngsuranController::class, 'store'])->name('angsuran.store');
    Route::post('angsuran/update', [AngsuranController::class, 'update'])->name('angsuran.update');
    Route::get('angsuran/{id}/edit', [AngsuranController::class, 'edit'])->name('angsuran.edit');
    Route::get('angsuran/{id}/delete_btn', [AngsuranController::class, 'deleteBtn'])->name('angsuran.delete_btn');
    Route::post('angsuran/delete', [AngsuranController::class, 'delete'])->name('angsuran.delete');

        // tambah angsuran
        Route::get('angsuran/{id}/tambah_angsuran', [AngsuranController::class, 'tambahAngsuran'])->name('angsuran.tambah_angsuran');
        Route::post('angsuran/tambah_angsuran/store', [AngsuranController::class, 'tambahAngsuranStore'])->name('angsuran.tambah_angsuran.store');
        Route::get('angsuran/tambah_angsuran/{angsuran_id}/edit', [AngsuranController::class, 'tambahAngsuranEdit'])->name('angsuran.tambah_angsuran.edit');
        Route::post('angsuran/tambah_angsuran/update', [AngsuranController::class, 'tambahAngsuranUpdate'])->name('angsuran.tambah_angsuran.update');
        Route::post('angsuran/tambah_angsuran/delete', [AngsuranController::class, 'tambahAngsuranDelete'])->name('angsuran.tambah_angsuran.delete');

        // bayar angsuran
        Route::get('angsuran/{id}/bayar_angsuran', [AngsuranController::class, 'bayarAngsuran'])->name('angsuran.bayar_angsuran');
        Route::get('angsuran/bayar_angsuran/{id}/create', [AngsuranController::class, 'bayarAngsuranCreate'])->name('angsuran.bayar_angsuran.create');
        Route::get('angsuran/bayar_angsuran/{id}/create_angsuran_ke', [AngsuranController::class, 'bayarAngsuranCreateAngsuranKe'])->name('angsuran.bayar_angsuran.create_angsuran_ke');
        Route::post('angsuran/bayar_angsuran/store', [AngsuranController::class, 'bayarAngsuranStore'])->name('angsuran.bayar_angsuran.store');
        Route::post('angsuran/bayar_angsuran/delete', [AngsuranController::class, 'bayarAngsuranDelete'])->name('angsuran.bayar_angsuran.delete');
});
