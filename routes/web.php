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

//Route::get('/admin', function () {
//    return view('home');
//});
//    ->middleware('Admin');

Auth::routes();
Route::get('/', function () {
    return view('home');
})->middleware(['auth','rolemiddleware']);

Route::get('/home', 'HomeController@index');
Route::get('/admin', 'HomeController@admin');

Route::resource('books','BooksController');
Route::resource('permissions','PermissionsController');
Route::resource('roles','RolesController');
Route::get('/allperms','RolesPermissionController@getAllPerms');
Route::post('/assign','RolesPermissionController@assignRoles');
Route::post('/remove','RolesPermissionController@detachingrolesandpermissions');
Route::get('/users','UserController@index');
Route::post('/toggle','RolesPermissionController@toggleUserRole');
Route::post('/order_book','BookUsersController@orderBook');
Route::post('/reserve_book','BookUsersController@reserveBook');
Route::get('/get_all_books','BookUsersController@getAllBooks');
Route::post('/return_book','BookUsersController@return_book');
Route::get('/users_books','BookUsersController@getBooks');
Route::get('/emailing','BookUsersController@sendingemails');
Route::get('/rolenperms','RolesPermissionController@gettingallrolesnadpermissions');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/books','BooksCommon@index');
//This is for downloading the pdf

////The books routes

Route::get('/index','PdfController@index');
Route::post('/books_edit','BooksController@update');
Route::get('/categories','CategoryController@index');

