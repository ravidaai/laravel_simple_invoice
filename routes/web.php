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

//Route::get('/', function () {
//    return view('welcome');
//});

// ROUTE TO OPEN ADMIN PAGE
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function ()
{
    return redirect('admin/dashboard');
});

// LOGIN GROUP
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['web', 'guest:admin', 'throttle:100,1']], function ()
{
    // LOGIN ROUTE
    Route::get('login', ['as' => 'admin.login.view', 'uses' =>'LoginController@getIndex']);
    Route::post('login', ['as' => 'admin.login.view', 'uses' => 'LoginController@postIndex']);
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['web', 'auth:admin', 'throttle:100,5']], function () {
    // MY PROFILE
    Route::get('dashboard', ['as' => 'admin.dashboard.view', 'uses' => 'DashboardController@getIndex']);
    Route::get('profile', ['as' => 'admin.dashboard.profile', 'uses' => 'DashboardController@getProfile']);
    Route::post('profile', ['as' => 'admin.dashboard.profile', 'uses' => 'DashboardController@postProfile']);
    Route::get('password', ['as' => 'admin.dashboard.password', 'uses' => 'DashboardController@getPassword']);
    Route::post('password', ['as' => 'admin.dashboard.password', 'uses' => 'DashboardController@postPassword']);

    // SETTINGS ROUTE
    Route::get('settings', ['as' => 'admin.settings.view', 'uses' => 'SettingsController@getIndex']);
    Route::post('settings', ['as' => 'admin.settings.list', 'uses' => 'SettingsController@postIndex']);

    // USERS ROUTE
    Route::get('users', ['as' => 'admin.users.view', 'uses' => 'UsersController@getIndex']);
    Route::get('users/list', ['as' => 'admin.users.list', 'uses' => 'UsersController@getList']);
    Route::get('users/add', ['as' => 'admin.users.add', 'uses' => 'UsersController@getAdd']);
    Route::post('users/add', ['as' => 'admin.users.add', 'uses' => 'UsersController@postAdd']);
    Route::get('users/edit/{id}', ['as' => 'admin.users.edit', 'uses' => 'UsersController@getEdit']);
    Route::post('users/edit/{id}', ['as' => 'admin.users.edit', 'uses' => 'UsersController@postEdit']);
    Route::get('users/password/{id}', ['as' => 'admin.users.password', 'uses' => 'UsersController@getPassword']);
    Route::post('users/password/{id}', ['as' => 'admin.users.password', 'uses' => 'UsersController@postPassword']);
    Route::get('users/delete/{id}', ['as' => 'admin.users.delete', 'uses' => 'UsersController@getDelete']);

    // COUNTRIES ROUTE
    Route::get('countries', ['as' => 'admin.countries.view','uses' => 'CountriesController@getIndex']);
    Route::get('countries/list', ['as' => 'admin.countries.list', 'uses' => 'CountriesController@getList']);
    Route::get('countries/add', ['as' => 'admin.countries.add', 'uses' => 'CountriesController@getAdd']);
    Route::post('countries/add', ['as' => 'admin.countries.add', 'uses' => 'CountriesController@postAdd']);
    Route::get('countries/edit/{id}', ['as' => 'admin.countries.edit', 'uses' => 'CountriesController@getEdit']);
    Route::post('countries/edit/{id}', ['as' => 'admin.countries.edit','uses' => 'CountriesController@postEdit']);
    Route::get('countries/delete/{id}', ['as' => 'admin.countries.delete', 'uses' => 'CountriesController@getDelete']);

    // CITIES ROUTE
    Route::get('cities', ['as' => 'admin.cities.view','uses' => 'CitiesController@getIndex']);
    Route::get('cities/list', ['as' => 'admin.cities.list', 'uses' => 'CitiesController@getList']);
    Route::get('cities/add', ['as' => 'admin.cities.add', 'uses' => 'CitiesController@getAdd']);
    Route::post('cities/add', ['as' => 'admin.cities.add', 'uses' => 'CitiesController@postAdd']);
    Route::get('cities/edit/{id}', ['as' => 'admin.cities.edit', 'uses' => 'CitiesController@getEdit']);
    Route::post('cities/edit/{id}', ['as' => 'admin.cities.edit','uses' => 'CitiesController@postEdit']);
    Route::get('cities/delete/{id}', ['as' => 'admin.cities.delete', 'uses' => 'CitiesController@getDelete']);

    // CURRENCIES ROUTE
    Route::get('currencies', ['as' => 'admin.currencies.view','uses' => 'CurrenciesController@getIndex']);
    Route::get('currencies/list', ['as' => 'admin.currencies.list', 'uses' => 'CurrenciesController@getList']);
    Route::get('currencies/add', ['as' => 'admin.currencies.add', 'uses' => 'CurrenciesController@getAdd']);
    Route::post('currencies/add', ['as' => 'admin.currencies.add', 'uses' => 'CurrenciesController@postAdd']);
    Route::get('currencies/edit/{id}', ['as' => 'admin.currencies.edit', 'uses' => 'CurrenciesController@getEdit']);
    Route::post('currencies/edit/{id}', ['as' => 'admin.currencies.edit','uses' => 'CurrenciesController@postEdit']);
    Route::get('currencies/delete/{id}', ['as' => 'admin.currencies.delete', 'uses' => 'CurrenciesController@getDelete']);

    // ITEMS ROUTE
    Route::get('items', ['as' => 'admin.items.view','uses' => 'ItemsController@getIndex']);
    Route::get('items/list', ['as' => 'admin.items.list', 'uses' => 'ItemsController@getList']);
    Route::get('items/add', ['as' => 'admin.items.add', 'uses' => 'ItemsController@getAdd']);
    Route::post('items/add', ['as' => 'admin.items.add', 'uses' => 'ItemsController@postAdd']);
    Route::get('items/edit/{id}', ['as' => 'admin.items.edit', 'uses' => 'ItemsController@getEdit']);
    Route::post('items/edit/{id}', ['as' => 'admin.items.edit','uses' => 'ItemsController@postEdit']);
    Route::get('items/delete/{id}', ['as' => 'admin.items.delete', 'uses' => 'ItemsController@getDelete']);
    Route::post('items/info', ['as' => 'admin.items.info', 'uses' => 'ItemsController@postItemInfo']);

    // PAYMENTS ROUTE
    Route::get('payments', ['as' => 'admin.payments.view','uses' => 'PaymentsController@getIndex']);
    Route::get('payments/list', ['as' => 'admin.payments.list', 'uses' => 'PaymentsController@getList']);
    Route::get('payments/add', ['as' => 'admin.payments.add', 'uses' => 'PaymentsController@getAdd']);
    Route::post('payments/add', ['as' => 'admin.payments.add', 'uses' => 'PaymentsController@postAdd']);
    Route::get('payments/edit/{id}', ['as' => 'admin.payments.edit', 'uses' => 'PaymentsController@getEdit']);
    Route::post('payments/edit/{id}', ['as' => 'admin.payments.edit','uses' => 'PaymentsController@postEdit']);
    Route::get('payments/delete/{id}', ['as' => 'admin.payments.delete', 'uses' => 'PaymentsController@getDelete']);

    // COMPANIES ROUTE
    Route::get('companies', ['as' => 'admin.companies.view','uses' => 'CompaniesController@getIndex']);
    Route::get('companies/list', ['as' => 'admin.companies.list', 'uses' => 'CompaniesController@getList']);
    Route::get('companies/add', ['as' => 'admin.companies.add', 'uses' => 'CompaniesController@getAdd']);
    Route::post('companies/add', ['as' => 'admin.companies.add', 'uses' => 'CompaniesController@postAdd']);
    Route::get('companies/edit/{id}', ['as' => 'admin.companies.edit', 'uses' => 'CompaniesController@getEdit']);
    Route::post('companies/edit/{id}', ['as' => 'admin.companies.edit','uses' => 'CompaniesController@postEdit']);
    Route::get('companies/delete/{id}', ['as' => 'admin.companies.delete', 'uses' => 'CompaniesController@getDelete']);
    Route::post('companies/info', ['as' => 'admin.companies.info', 'uses' => 'CompaniesController@postCompanyInfo']);
    Route::post('companies/tax', ['as' => 'admin.companies.tax', 'uses' => 'CompaniesController@postTaxInfo']);

    // CONTACTS ROUTE
    Route::get('contacts', ['as' => 'admin.contacts.view','uses' => 'ContactsController@getIndex']);
    Route::get('contacts/list', ['as' => 'admin.contacts.list', 'uses' => 'ContactsController@getList']);
    Route::get('contacts/add', ['as' => 'admin.contacts.add', 'uses' => 'ContactsController@getAdd']);
    Route::post('contacts/add', ['as' => 'admin.contacts.add', 'uses' => 'ContactsController@postAdd']);
    Route::get('contacts/edit/{id}', ['as' => 'admin.contacts.edit', 'uses' => 'ContactsController@getEdit']);
    Route::post('contacts/edit/{id}', ['as' => 'admin.contacts.edit','uses' => 'ContactsController@postEdit']);
    Route::get('contacts/delete/{id}', ['as' => 'admin.contacts.delete', 'uses' => 'ContactsController@getDelete']);
    Route::post('contacts/info', ['as' => 'admin.contacts.info', 'uses' => 'ContactsController@postContactInfo']);

    // BRANCHES ROUTE
    Route::get('branches', ['as' => 'admin.branches.view','uses' => 'BranchesController@getIndex']);
    Route::get('branches/list', ['as' => 'admin.branches.list', 'uses' => 'BranchesController@getList']);
    Route::get('branches/add', ['as' => 'admin.branches.add', 'uses' => 'BranchesController@getAdd']);
    Route::post('branches/add', ['as' => 'admin.branches.add', 'uses' => 'BranchesController@postAdd']);
    Route::get('branches/edit/{id}', ['as' => 'admin.branches.edit', 'uses' => 'BranchesController@getEdit']);
    Route::post('branches/edit/{id}', ['as' => 'admin.branches.edit','uses' => 'BranchesController@postEdit']);
    Route::get('branches/delete/{id}', ['as' => 'admin.branches.delete', 'uses' => 'BranchesController@getDelete']);

    // INVOICES ROUTE
    Route::get('invoices', ['as' => 'admin.invoices.view','uses' => 'InvoicesController@getIndex']);
    Route::get('invoices/list', ['as' => 'admin.invoices.list', 'uses' => 'InvoicesController@getList']);
    Route::get('invoices/add', ['as' => 'admin.invoices.add', 'uses' => 'InvoicesController@getAdd']);
    Route::post('invoices/add', ['as' => 'admin.invoices.add', 'uses' => 'InvoicesController@postAdd']);
    Route::get('invoices/edit/{id}', ['as' => 'admin.invoices.edit', 'uses' => 'InvoicesController@getEdit']);
    Route::post('invoices/edit/{id}', ['as' => 'admin.invoices.edit','uses' => 'InvoicesController@postEdit']);
    Route::get('invoices/attachments/list/{id}', ['as' => 'admin.invoices.attachments.list', 'uses' => 'InvoicesController@getAttachmentList']);
    Route::get('invoices/attachments/{id}', ['as' => 'admin.invoices.attachments', 'uses' => 'InvoicesController@getAttachment']);
    Route::post('invoices/attachments/{id}', ['as' => 'admin.invoices.attachments','uses' => 'InvoicesController@postAttachment']);
    Route::get('invoices/attachments/delete/{id}', ['as' => 'admin.invoices.attachments.delete','uses' => 'InvoicesController@postDeleteAttachment']);
    Route::get('invoices/payments/list/{id}', ['as' => 'admin.invoices.payments.list', 'uses' => 'InvoicesController@getPaymentList']);
    Route::get('invoices/payments/{id}', ['as' => 'admin.invoices.payments', 'uses' => 'InvoicesController@getPayment']);
    Route::post('invoices/payments/{id}', ['as' => 'admin.invoices.payments','uses' => 'InvoicesController@postPayment']);
    Route::get('invoices/payments/delete/{id}', ['as' => 'admin.invoices.payments.delete','uses' => 'InvoicesController@postDeletePayment']);
    Route::get('invoices/print/{id}', ['as' => 'admin.invoices.invoice', 'uses' => 'InvoicesController@getPrint']);
    Route::get('invoices/delete/{id}', ['as' => 'admin.invoices.delete', 'uses' => 'InvoicesController@getDelete']);

    //Reports ROUTE
    Route::get('reports/items', ['as' => 'admin.reports.items', 'uses' => 'ReportsController@getItems']);
    Route::get('reports/contacts', ['as' => 'admin.reports.contacts', 'uses' => 'ReportsController@getContacts']);
    Route::get('reports/list', ['as' => 'admin.reports.list', 'uses' => 'ReportsController@getList']);
    Route::post('reports/statistics', ['as' => 'admin.reports.statistics', 'uses' => 'ReportsController@postStatistics']);

    // LOGOUT ROUTE
    Route::get('logout', ['as' => 'admin.dashboard.logout', 'uses' => 'LoginController@getLogout']);
});

// Dictionary Route
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function ()
{
    Route::get('dictionary.js', function () {

        return response()->view('admin.common.data')->header('content-type', 'text/javascript; charset=utf-8');
    })->name('admin.common.view');
});

Route::get('mail', function () {
    if (env('APP_ENV') != 'production') {
        $data = array(
            'name' => "Nael W. Skaik",
            'email' => "nskaik@gmail.com",
            'email_verification_token' => 'EMAIL_VERIFICATION_TOKEN',
        );

        Mail::send('mail', $data, function ($message) use ($data) {
            $message->from('info@pandavoiceover.com', 'PandaVoiceOver');
            $message->to($data['email'])->subject('Welcome to PandaVoiceOver ' . $data['name'] . ' !');
        });
    }
});