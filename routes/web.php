<?php

use App\Http\Livewire\BootstrapTables;
use App\Http\Livewire\Components\Buttons;
use App\Http\Livewire\Components\Forms;
use App\Http\Livewire\Components\Modals;
use App\Http\Livewire\Components\Notifications;
use App\Http\Livewire\Components\Typography;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Err404;
use App\Http\Livewire\Err500;
use App\Http\Livewire\ResetPassword;
use App\Http\Livewire\ForgotPassword;
use App\Http\Livewire\Lock;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\ForgotPasswordExample;
use App\Http\Livewire\Index;
use App\Http\Livewire\LoginExample;
use App\Http\Livewire\Order\Index as OrderIndex;
use App\Http\Livewire\ProfileExample;
use App\Http\Livewire\RegisterExample;
use App\Http\Livewire\Transactions;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ResetPasswordExample;
use App\Http\Livewire\UpgradeToPro;
use App\Http\Livewire\Users;
use App\Http\Livewire\Product\Form;
use App\Http\Livewire\Product\Index as ProductIndex;
use App\Http\Livewire\Product\Update;
use App\Http\Livewire\Report\Expiry;
use App\Http\Livewire\Report\IncomeVsExpenses;
use App\Http\Livewire\Report\PurchasesAndExpenses;
use App\Http\Livewire\Report\SalesAndIncome;
use App\Http\Livewire\Report\StockValue;
use App\Http\Livewire\Stock\Index as StockIndex;
use App\Models\Stock;
use Illuminate\Http\Request;

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

Route::redirect('/', '/login');

Route::get('/register', Register::class)->name('register');

Route::get('/login', Login::class)->name('login');

Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');

Route::get('/reset-password/{id}', ResetPassword::class)->name('reset-password')->middleware('signed');

Route::get('/404', Err404::class)->name('404');
Route::get('/500', Err500::class)->name('500');
Route::get('/upgrade-to-pro', UpgradeToPro::class)->name('upgrade-to-pro');

Route::middleware('auth')->group(function () {
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/profile-example', ProfileExample::class)->name('profile-example');
    Route::get('/users', Users::class)->name('users');
    Route::get('/login-example', LoginExample::class)->name('login-example');
    Route::get('/register-example', RegisterExample::class)->name('register-example');
    Route::get('/forgot-password-example', ForgotPasswordExample::class)->name('forgot-password-example');
    Route::get('/reset-password-example', ResetPasswordExample::class)->name('reset-password-example');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/transactions', Transactions::class)->name('transactions');
    Route::get('/bootstrap-tables', BootstrapTables::class)->name('bootstrap-tables');
    Route::get('/lock', Lock::class)->name('lock');
    Route::get('/buttons', Buttons::class)->name('buttons');
    Route::get('/notifications', Notifications::class)->name('notifications');
    Route::get('/forms', Forms::class)->name('forms');
    Route::get('/modals', Modals::class)->name('modals');
    Route::get('/typography', Typography::class)->name('typography');

    Route::get('/products', ProductIndex::class)->name('products.index');
    Route::get('/products/create', Form::class)->name('products.create');
    Route::get('/products/{product}/edit', Update::class)->name('products.edit');

    Route::get('/stock', StockIndex::class)->name('stock.index');
    Route::get('/stock/create', \App\Http\Livewire\Stock\Form::class)->name('stock.create');
    Route::get('/stock/{stockItem}/edit', \App\Http\Livewire\Stock\Update::class)->name('stock.edit');

    // Order routes
    Route::get('/orders', OrderIndex::class)->name('orders.index');
    Route::get('/orders/create', \App\Http\Livewire\Order\Create\Form::class)->name('orders.create');
    Route::get('/orders/{order}/edit', \App\Http\Livewire\Order\Update\Form::class)->name('orders.edit');
    Route::get('/orders/{order}/payments', \App\Http\Livewire\Order\Payment::class)->name('orders.payments');
    Route::get('/orders/{order}/payments/{payment}/edit', \App\Http\Livewire\Order\Payment::class)->name('orders.payments.edit');
    Route::get('/orders/{order}', \App\Http\Livewire\Order\Bill::class)->name('orders.bill');

    Route::get('/purchases-and-expenses', PurchasesAndExpenses::class)->name('purchases-and-expenses');
    Route::get('/sales-and-income', SalesAndIncome::class)->name('sales-and-income');
    Route::get('/income-vs-expenses', IncomeVsExpenses::class)->name('income-vs-expenses');
    Route::get('/expiry-report', Expiry::class)->name('expiry-report');
    Route::get('/stock-value', StockValue::class)->name('stock-value');
});
