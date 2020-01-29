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
})->middleware('auth');

Route::get('/home', 'HomeController@index');

Route::resource('books','BooksController');
Route::resource('permissions','PermissionsController');
Route::resource('roles','RolesController');
Route::get('/allperms','RolesPermissionController@getAllPerms');
Route::post('/assign','RolesPermissionController@assignRoles');
Route::post('/remove','RolesPermissionController@detachingrolesandpermissions');
Route::get('/users','UserController@index');
Route::post('/toggle','RolesPermissionController@toggleUserRole');
Route::post('/orderbook','BookUsersController@orderBook');
Route::post('/reservebook','BookUsersController@reservebook');
Route::get('/getallbooks','BookUsersController@getAllBooks');
Route::post('/returnbook','BookUsersController@returnbook');
Route::get('/bookscount','BookUsersController@getBooks');
Route::get('/emailing','BookUsersController@sendingemails');
Route::get('/rolenperms','RolesPermissionController@gettingallrolesnadpermissions');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
