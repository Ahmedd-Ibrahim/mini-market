<?php

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
Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ],
    function()
{
    /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/

/* Start Dashboard route */
    Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function(){
        Route::get('/','DashboardController@index')->name('welcome');
        // Users Route
        Route::resource('users','UserController')->except(['show']);
        //Categories Route
        Route::resource('categories','categoryController')->except(['show']);
        // Products Route
        Route::resource('products','ProductController')->except(['show']);
        // Clients Route
        Route::resource('clients','ClientController')->except(['show']);
        Route::resource('clients.orders', 'Clients\OrderController')->except(['show']);
        // Order Route
        Route::resource('orders','OrderController')->except(['show']);
        Route::get('/orders/{order}/products','OrderController@products')->name('orders.products');



    }); // End of dashboard routes

});  // End of laravelLocalization

