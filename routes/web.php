<?php

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
	// return view('layouts.homes.index');
	return redirect('/login');
});
Route::get('/signup', 'HomeCtrl@signup');

Auth::routes();

Route::get('/home', 'HomeCtrl@index')->name('home');

//============== CASTOM ROUTE ============
	Route::get('/user/delete/{id}','UserCtrl@destroy')->name('user.delete');
	Route::get('/category/delete/{id}','CategoryCtrl@destroy')->name('category.delete');
	Route::get('/sub_category/delete/{id}','SubCategoryCtrl@destroy')->name('sub_category.delete');
	Route::get('/vendor/delete/{id}','VendorCtrl@destroy')->name('vendor.delete');
	Route::get('/product/delete/{id}','ProductCtrl@destroy')->name('product.delete');
	Route::get('/customer/delete/{id}','CustomerCtrl@destroy')->name('customer.delete');


	// Route::get('/payment/{id}/get', 'PaymentCtrl@getPayment')->name('get.payment');
	// Route::get('/payment/{id}/index', 'PaymentCtrl@index')->name('index.payment');
	// Route::get('/payment/{id}/read', 'PaymentCtrl@show')->name('show.payment');
	// Route::get('/payment/{id}/delete','PaymentCtrl@destroy')->name('payment.delete');

	//password change
	Route::get('/change_password', 'UserCtrl@changePassword')->name('user.password.change');
	Route::put('/change_password', 'UserCtrl@updatePassword')->name('user.change.password');

//=================== CASTOM ROUTE END ==========================
	
	//user routes
	Route::resource('/user', 'UserCtrl');
	Route::resource('/category', 'CategoryCtrl');

	Route::resource('/sub_category', 'SubCategoryCtrl');
	Route::get('/get_sub_cats/{catid}', 'SubCategoryCtrl@subCats');

	Route::resource('/vendor', 'VendorCtrl');
	Route::post('/vendor/search', 'VendorCtrl@search')->name('vendor.search');
	Route::resource('/product', 'ProductCtrl');

	/** expence routes */
	Route::resource('/expense', 'ExpenseCtrl');
	Route::get('/expense_tracking', 'ExpenseCtrl@tracking')->name('expense.track');
	Route::post('/expense_tracking', 'ExpenseCtrl@earningPost')->name('earning.post');
	Route::post('/expense_filter', 'ExpenseCtrl@filter')->name('expense.filter');
	
	Route::resource('/customer', 'CustomerCtrl');
	Route::get('/search/customer/{value}', 'CustomerCtrl@searchCustomer');
	Route::post('/search/customer', 'CustomerCtrl@searchCustomer')->name('customer.search');
	Route::post('/customer/search', 'CustomerCtrl@search')->name('search.customer');
	Route::resource('/sale', 'SaleCtrl');
	// Route::get('/sale/{customer}/product', 'SaleCtrl@saleProduct');
	Route::get('/sale/{id}/print', 'SaleCtrl@print');
	Route::get('/sale/delete/{id}','SaleCtrl@destroy')->name('sale.delete');
	Route::get('/search/orders/{value}', 'SaleCtrl@search');
	Route::get('/invoice_create/{type}', 'SaleCtrl@createByType')->name('sale.create.type');
	Route::get('/invoice_copy/{ticket_no}', 'SaleCtrl@invoiceCopy')->name('sale.copy');
	Route::get('/invoice_edit/{key}', 'SaleCtrl@invoiceSessionEdit')->name('sale.session.edit');
	Route::put('invoice_update/{key}', 'SaleCtrl@invoiceUpdate')->name('sale.session.update');
	Route::post('/invoice_store_session', 'SaleCtrl@storeSession')->name('sale.store.session');
	Route::get('/invoice_delete/{id}/{type}', 'SaleCtrl@invoiceSessionDelete')->name('sale.session.delete');
	Route::get('/invoice_store_multiple', 'SaleCtrl@storeMulti')->name('sale.store.multi');
	Route::get('/invoice/{type}/close', 'SaleCtrl@invoiceClose')->name('sale.session.close');
	Route::get('/invoice_view/{type}', 'SaleCtrl@viewSalesByType')->name('sale.view.type');

	Route::post('/add_new_client', 'SaleCtrl@addNewClient')->name('sale.add.client');
	Route::get('/invoice_print/{id}', 'SaleCtrl@invoicePrint')->name('sale.invoice.print');

	Route::get('/sale_reissue/{id}', 'SaleCtrl@reIssue')->name('sale.reissue');
	Route::put('/sale_reissue_update/{id}', 'SaleCtrl@reIssueUpdate')->name('sale.reissue.update');
	Route::get('/view_reissued_invoice', 'SaleCtrl@viewReissued')->name('sale.reissue.index');
	Route::post('/invoice_search', 'SaleCtrl@searchInvoice')->name('invoice.search');

	/** -------------  invoices others ----------------- */
	Route::get('/invoice/{type}/create', 'SaleCtrl@invoiceCreate')->name('invoice.type.create');
	Route::get('/invoice/{type}/index', 'SaleCtrl@invoiceIndex')->name('invoice.type.index');
	Route::post('/invoice_store', 'SaleCtrl@invoiceStore')->name('invoice.type.store');
	Route::get('/invoice_show/{id}', 'SaleCtrl@invoiceShow')->name('invoice.show');
	Route::get('/invoice/{type}/{id}/edit', 'SaleCtrl@invoiceEdit')->name('invoice.type.edit');
	Route::put('/invoice_other/{id}', 'SaleCtrl@invoiceOtherUpdate')->name('invoice.type.update');
	Route::get('/invoice_other/{id}/print', 'SaleCtrl@printOther')->name('invoice.other.print');
	Route::get('/invoice/{id}/delete', 'SaleCtrl@invoiceDelete')->name('invoice.type.delete');

	/** -------------- Re-Fund Routes ------------------- */
	Route::get('/invoice_refund/create', 'RefundCtrl@refundCreate')->name('sale.refund.create');
	Route::post('/invoice_refund', 'RefundCtrl@refundStore')->name('sale.refund.store');
	Route::get('/invoice_refund', 'RefundCtrl@refundIndex')->name('sale.refund.index');
	Route::get('/invoice_refund/{id}', 'RefundCtrl@refundShow')->name('sale.refund.show');
	Route::get('/invoice_refund/{id}/delete', 'RefundCtrl@refundDelete')->name('sale.refund.delete');

	/** ajax call */
	Route::get('/search_clients/{name}', 'SaleCtrl@searchClients');
	Route::get('/search_invoices/{client}', 'SaleCtrl@searchInvoices');
	Route::get('/get_ticket/{id}', 'SaleCtrl@getTicket');

	Route::get('/get_airlines/{name}', 'SaleCtrl@getAirlines');
	Route::get('/sale/print/{id}/change', 'SaleCtrl@changePrintStatus');

	//payments
	Route::resource('/payment', 'PaymentCtrl');
	Route::get('/payment/{type}/create', 'PaymentCtrl@createType')->name('payment.create.type');
	Route::get('/payment/{type}/view', 'PaymentCtrl@getPaymentByType')->name('payment.type.index');
	Route::get('/payment/{type}/{id}', 'PaymentCtrl@typeShow')->name('payment.type.show');
	Route::get('/payment_print/{id}/print', 'PaymentCtrl@print')->name('payment.print');

	/** get balance by ajax */
	Route::get('payment_balance/{type}/{id}', 'PaymentCtrl@getBalance')->name('payment.balance');


	/** settings routes */
	Route::get('airlines', 'SettingCtrl@airlines')->name('airlines');
	Route::post('airlines/store', 'SettingCtrl@airlinesStore')->name('airlines.store');
	Route::get('airlines/{id}/delete', 'SettingCtrl@airlineDelete')->name('airline.delete');

	/** employee routes */
	Route::resource('employee', EmployeeCtrl::class);

	/** accounts */
	Route::resource('account', AccountCtrl::class);
	Route::get('/get_balance/{id}', 'AccountCtrl@getBalance');
	Route::get('/account_', 'AccountCtrl@statement')->name('account.statement');
	Route::post('/account_', 'AccountCtrl@getStatement')->name('account.post');
	Route::get('/fund_transfer/{id}', 'AccountCtrl@fundTransfer')->name('fund.transfer.create');
	Route::post('/fund_transfer', 'AccountCtrl@fundTransferStore')->name('fund.transfer.store');
	Route::get('/fund_transfer', 'AccountCtrl@fundTransferIndex')->name('fund.transfer.index');

	/** reports	 */
	Route::get('/report', 'ReportCtrl@create')->name('report.create');
	Route::post('/report', 'ReportCtrl@index')->name('report.post');
	Route::get('/sales_report', 'ReportCtrl@saleCreate')->name('report.sale');
	Route::post('/sales_report', 'ReportCtrl@saleIndex')->name('report.sale.post');
	Route::get('/client_report', 'ReportCtrl@clientReport')->name('report.client');
	Route::post('/client_report', 'ReportCtrl@clientPost')->name('report.client.post');
	Route::get('/vendor_report', 'ReportCtrl@vendorReport')->name('report.vendor');
	Route::post('/vendor_report', 'ReportCtrl@vendorPost')->name('report.vendor.post');

	// Route::get('/report_create_test', 'ReportCtrl@reportTest');

	/** temp invoice update */
	// Route::get('/temp_report_update', 'ReportCtrl@tempReportUpdate');