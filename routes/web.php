<?php

use App\Http\Controllers\BackEnd\AccountInfoController;
use App\Http\Controllers\BackEnd\BlendController;
use App\Http\Controllers\BackEnd\CategoryController;
use App\Http\Controllers\BackEnd\CompanyControll;
use App\Http\Controllers\BackEnd\customerController;
use App\Http\Controllers\BackEnd\ExpenseController;
use App\Http\Controllers\BackEnd\InvoiceController;
use App\Http\Controllers\BackEnd\ItemController;
use App\Http\Controllers\BackEnd\PaymentController;
use App\Http\Controllers\BackEnd\PurchaseController;
use App\Http\Controllers\BackEnd\PurchaseReturnControl;
use App\Http\Controllers\BackEnd\ReportController;
use App\Http\Controllers\BackEnd\ResetPasswordController;
use App\Http\Controllers\BackEnd\SaleReturnController;
use App\Http\Controllers\BackEnd\Stockcontroller;
use App\Http\Controllers\BackEnd\TransferController;
use App\Http\Controllers\BackEnd\UserController;
use App\Http\Controllers\BackEnd\UserProfileController;
use App\Http\Controllers\BackEnd\vendorController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'General-Setting'], function () {
        Route::get('/show', [CompanyControll::class, 'show'])->name('general.show');
        Route::post('/update', [CompanyControll::class, 'update'])->name('general.update');

    });

    Route::group(['prefix' => 'Category'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories');
        Route::get('/loadall', [CategoryController::class, 'LoadAll'])->name('category.loadall');
        Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/update', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');
    });

    Route::group(['prefix' => 'Item'], function () {
        Route::get('/', [ItemController::class, 'index'])->name('items');
        Route::get('/loadall', [ItemController::class, 'LoadAll'])->name('item.loadall');
        Route::get('/create', [ItemController::class, 'create'])->name('item.create');
        Route::post('/store', [ItemController::class, 'store'])->name('item.store');
        Route::get('/edit/{id}', [ItemController::class, 'edit'])->name('item.edit');
        Route::post('/update', [ItemController::class, 'update'])->name('item.update');
        Route::delete('/delete/{id}', [ItemController::class, 'destroy'])->name('item.delete');
        Route::get('/getlist', [ItemController::class, 'getlist'])->name('item.getlist');

        //Stock
        Route::get('/item/Stock', [Stockcontroller::class, 'index'])->name('item.stock');
        Route::get('/stock/loadall', [Stockcontroller::class, 'LoadAll'])->name('item.stock.loadall');
    });

    Route::group(['prefix' => 'Customer'], function () {
        Route::get('/', [customerController::class, 'index'])->name('customers');
        Route::get('/loadall', [customerController::class, 'LoadAll'])->name('customer.loadall');
        Route::get('/create', [customerController::class, 'create'])->name('customer.create');
        Route::post('/store', [customerController::class, 'store'])->name('customer.store');
        Route::get('/edit/{id}', [customerController::class, 'edit'])->name('customer.edit');
        Route::post('/update', [customerController::class, 'update'])->name('customer.update');
        Route::delete('/delete/{id}', [customerController::class, 'destroy'])->name('customer.delete');
    });

    Route::group(['prefix' => 'Vendor'], function () {
        Route::get('/', [vendorController::class, 'index'])->name('vendors');
        Route::get('/loadall', [vendorController::class, 'LoadAll'])->name('vendor.loadall');
        Route::get('/create', [vendorController::class, 'create'])->name('vendor.create');
        Route::post('/store', [vendorController::class, 'store'])->name('vendor.store');
        Route::get('/edit/{id}', [vendorController::class, 'edit'])->name('vendor.edit');
        Route::post('/update', [vendorController::class, 'update'])->name('vendor.update');
        Route::delete('/delete/{id}', [vendorController::class, 'destroy'])->name('vendor.delete');
    });

    Route::group(['prefix' => 'Invoice'], function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('invoices');
        Route::get('/loadall', [InvoiceController::class, 'Loadall'])->name('invoice.loadall');
        Route::get('/create', [InvoiceController::class, 'create'])->name('invoice.create');
        Route::post('/store', [InvoiceController::class, 'store'])->name('invoice.store');
        Route::get('/show/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
        Route::get('/edit/{id}', [InvoiceController::class, 'edit'])->name('invoice.edit');
        Route::post('/update', [InvoiceController::class, 'update'])->name('invoice.update');
        Route::get('/pdf/{id}', [InvoiceController::class, 'invoicepdf'])->name('invoice.pdf');
        Route::delete('/delete/{id}', [InvoiceController::class, 'destroy'])->name('invoice.delete');
        Route::post('/newcustomer', [InvoiceController::class, 'NewCustomer'])->name('invoice.newcustomer');
    });

    Route::group(['prefix' => 'Purchase'], function () {
        Route::get('/', [PurchaseController::class, 'index'])->name('purchases');
        Route::get('/loadall', [PurchaseController::class, 'Loadall'])->name('purchase.loadall');
        Route::get('/create', [PurchaseController::class, 'create'])->name('purchase.create');
        Route::post('/store', [PurchaseController::class, 'store'])->name('purchase.store');
        Route::get('/show/{id}', [PurchaseController::class, 'show'])->name('purchase.show');
        Route::get('/edit/{id}', [PurchaseController::class, 'edit'])->name('purchase.edit');
        Route::post('/update', [PurchaseController::class, 'update'])->name('purchase.update');
        Route::get('/pdf/{id}', [PurchaseController::class, 'purchasepdf'])->name('purchase.pdf');
        Route::post('/newvendor', [PurchaseController::class, 'newVendor'])->name('purchase.newvendor');
    });

//

    Route::group(['prefix' => 'Account'], function () {
        Route::get('/', [AccountInfoController::class, 'index'])->name('accounts');
        Route::get('/loadall', [AccountInfoController::class, 'LoadAll'])->name('account.loadall');
        Route::get('/create', [AccountInfoController::class, 'create'])->name('account.create');
        Route::post('/store', [AccountInfoController::class, 'store'])->name('account.store');
        Route::get('/edit/{id}', [AccountInfoController::class, 'edit'])->name('account.edit');
        Route::post('/update', [AccountInfoController::class, 'update'])->name('account.update');
        Route::get('/show/{id}', [AccountInfoController::class, 'show'])->name('account.show');
        Route::get('/LoadAllAccountDetails/{id}', [AccountInfoController::class, 'LoadAllAccountDetails'])->name('account.LoadAllAccountDetails');
    });
    Route::group(['prefix' => 'Payment'], function () {
        Route::get('/', [PaymentController::class, 'index'])->name('payments');
        Route::get('/loadall', [PaymentController::class, 'LoadAll'])->name('payment.loadall');
        Route::post('/payment', [PaymentController::class, 'store'])->name('account.payment');
        Route::get('/paymentshow/{id}', [PaymentController::class, 'show'])->name('account.payment.show');
        Route::get('/paymentshow/pdf/{id}', [PaymentController::class, 'RecieptdPdf'])->name('account.payment.pdf');
/*     Route::delete('/delete/{id}', [customerController::class, 'destroy'])->name('customer.delete'); */
    });

    Route::group(['prefix' => 'Expense'], function () {
        Route::get('/', [ExpenseController::class, 'index'])->name('expenses');
        Route::get('/create', [ExpenseController::class, 'create'])->name('expense.create');
        Route::post('/store', [ExpenseController::class, 'store'])->name('expense.store');
        Route::get('/loadall', [ExpenseController::class, 'loadall'])->name('expense.loadall');
        Route::get('/edit/{id}', [ExpenseController::class, 'edit'])->name('expense.edit');
        Route::post('/update', [ExpenseController::class, 'update'])->name('expense.update');
    });

    Route::group(['prefix' => 'Transfer'], function () {
        Route::get('/', [TransferController::class, 'index'])->name('transfers');
        Route::get('/create', [TransferController::class, 'create'])->name('transfer.create');
        Route::post('/store', [TransferController::class, 'store'])->name('transfer.store');
        Route::get('/loadall', [TransferController::class, 'loadall'])->name('transfer.loadall');
        Route::get('/show/{id}', [TransferController::class, 'show'])->name('transfer.show');
        Route::get('/edit/{id}', [TransferController::class, 'edit'])->name('transfer.edit');
        Route::post('/update', [TransferController::class, 'update'])->name('transfer.update');
        Route::post('/delete', [TransferController::class, 'destroy'])->name('transfer.delete');
        Route::get('/pdf/{id}', [TransferController::class, 'TransferPdf'])->name('transfer.pdf');
    });

    Route::group(['prefix' => 'Sale-Return'], function () {
        Route::get('/', [SaleReturnController::class, 'index'])->name('salereturns');
        Route::get('/create/{id}', [SaleReturnController::class, 'create'])->name('salereturn.create');
        Route::post('/store', [SaleReturnController::class, 'store'])->name('salereturn.store');
        Route::get('/show/{id}', [SaleReturnController::class, 'show'])->name('salereturn.show');
        Route::get('/loadall', [SaleReturnController::class, 'loadall'])->name('salereturn.loadall');
        Route::get('/edit/{id}', [SaleReturnController::class, 'edit'])->name('salereturn.edit');
    });

    Route::group(['prefix' => 'Purchase-Return'], function () {
        Route::get('/', [PurchaseReturnControl::class, 'index'])->name('purchasereturns');
        Route::get('/create/{id}', [PurchaseReturnControl::class, 'create'])->name('purchasereturn.create');
        Route::post('/store', [PurchaseReturnControl::class, 'store'])->name('purchasereturn.store');
        Route::get('/show/{id}', [PurchaseReturnControl::class, 'show'])->name('purchasereturn.show');
        Route::get('/loadall', [PurchaseReturnControl::class, 'loadall'])->name('purchasereturn.loadall');
        Route::get('/edit/{id}', [PurchaseReturnControl::class, 'edit'])->name('purchasereturn.edit');
    });

    Route::group(['prefix' => 'User'], function () {
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::get('/loadall', [UserController::class, 'LoadAll'])->name('user.loadall');
        Route::post('/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
    });
    Route::group(['prefix' => 'Reset-Password'], function () {
        Route::get('/', [ResetPasswordController::class, 'index'])->name('reset.password');
        Route::post('reset-password', [ResetPasswordController::class, 'updatePassword'])->name('reset.update');
    });
    Route::group(['prefix' => 'UserProfile'], function () {
        Route::get('/profile', [UserProfileController::class, 'Profile'])->name('user.profile');
        Route::post('/ImageChange', [UserProfileController::class, 'ImageChange'])->name('user.ImageChange');
    });

    //Blend
    Route::group(['prefix' => 'Blend'], function () {
        Route::get('/', [BlendController::class, 'index'])->name('blends');
        Route::get('/loadall', [BlendController::class, 'Loadall'])->name('blend.loadall');
        Route::get('/create', [BlendController::class, 'create'])->name('blend.create');
        Route::post('/store', [BlendController::class, 'store'])->name('blend.store');
        Route::get('/show/{id}', [BlendController::class, 'show'])->name('blend.show');
        Route::get('/edit/{id}', [BlendController::class, 'edit'])->name('blend.edit');
        Route::post('/update', [BlendController::class, 'update'])->name('blend.update');
        Route::delete('/delete/{id}', [BlendController::class, 'destroy'])->name('blend.delete');
    });

    //Report
    Route::group(['prefix' => 'Report'], function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports');
        Route::get('/reportquery', [ReportController::class, 'reportQuery'])->name('report.reportquery');
        //purchase
        Route::get('/purchase', [ReportController::class, 'purchaseCreate'])->name('report.purchase');
        Route::get('/purchseView', [ReportController::class, 'purchseView'])->name('report.purchseView');
        Route::get('/purchaseData', [ReportController::class, 'purchaseData'])->name('report.purchaseData');
        Route::get('/purchasePdf', [ReportController::class, 'purchasePdf'])->name('report.purchasePdf');

        //Purchase Payment
        Route::get('/purchasePaymentCreate', [ReportController::class, 'purchasePaymentCreate'])->name('report.purchasePaymentCreate');
        Route::get('/purchsePaymentView', [ReportController::class, 'purchsePaymentView'])->name('report.purchsePaymentView');
        Route::get('/purchasePaymentData', [ReportController::class, 'purchasePaymentData'])->name('report.purchasePaymentData');
        Route::get('/purchasePaymentPdf', [ReportController::class, 'purchasePaymentPdf'])->name('report.purchasePaymentPdf');

        //invoice
        Route::get('/invoice', [ReportController::class, 'invoiceCreate'])->name('report.invoice');
        Route::get('/invoiceView', [ReportController::class, 'invoiceView'])->name('report.invoiceView');
        Route::get('/invoiceData', [ReportController::class, 'invoiceData'])->name('report.invoiceData');
        Route::get('/invoicePdf', [ReportController::class, 'invoicePdf'])->name('report.invoicePdf');

        //invoice Payment
        Route::get('/invoicePaymentCreate', [ReportController::class, 'invoicePaymentCreate'])->name('report.invoicePaymentCreate');
        Route::get('/invoicePaymentView', [ReportController::class, 'invoicePaymentView'])->name('report.invoicePaymentView');
        Route::get('/invoicePaymentData', [ReportController::class, 'invoicePaymentData'])->name('report.invoicePaymentData');
        Route::get('/invoicePaymentPdf', [ReportController::class, 'invoicePaymentPdf'])->name('report.invoicePaymentPdf');
        
        //transection
        Route::get('/transectionCreate', [ReportController::class, 'transectionCreate'])->name('report.transectionCreate');
        Route::get('/transectionView', [ReportController::class, 'transectionView'])->name('report.transectionView');
        Route::get('/transectionData', [ReportController::class, 'transectionData'])->name('report.transectionData');
        Route::get('/transectionPdf', [ReportController::class, 'transectionPdf'])->name('report.transectionPdf');
    });

});
Auth::routes();
