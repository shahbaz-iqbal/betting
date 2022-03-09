<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\BettingController;
use App\Http\Controllers\PointController;
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

Route::get('/s', function () {
    return view('welcome');
});
Route::get('/dashboard', [HomeController::class, 'dashboard']);
Route::get('/dashboard_count', [HomeController::class, 'dashboard_count']);

Route::get('/logout', [HomeController::class, 'logout']);
Route::get('/', [HomeController::class, 'index']);
Route::post('/check_login', [HomeController::class, 'check_login']);
Route::get('/admin_edit', [HomeController::class, 'admin_edit']);
Route::post('/admin_update', [HomeController::class, 'admin_update']);

// $routes->get('/', 'Home::login');
// $routes->get('logout', 'Home::logout');
// $routes->post('check_login', 'Home::check_login');
// $routes->get('dashboard', 'Home::index');
// $routes->get('admin_edit', 'Home::admin_edit');
// $routes->post('admin_update', 'Home::admin_update');
/*
|--------------------------------------------------------------------------
| Users
|--------------------------------------------------------------------------
*/
Route::get('/users', [UserController::class, 'index']);
Route::get('/user_add', [UserController::class, 'add']);
Route::get('/showAll', [UserController::class, 'showAll']);
Route::get('/user_edit/{id}', [UserController::class, 'edit']);
Route::get('/user_edit_data/{id}', [UserController::class, 'edit_response']);
Route::post('/user_insert', [UserController::class, 'insert']);
Route::post('/user_update', [UserController::class, 'update']);
Route::get('/user_delete/{id}', [UserController::class, 'delete']);
Route::get('/user_view/{id}', [UserController::class, 'view']);
Route::get('/user_detail/{id}', [UserController::class, 'detail']);
Route::get('/specific_match_detail/{id}/{cat}', [UserController::class, 'specific_match_detail']); 
Route::get('/match_detail/{id}/{cat}', [UserController::class, 'match_detail']);
Route::get('/user_detail_only/{id}', [UserController::class, 'user_detail_only']);
/*
|--------------------------------------------------------------------------
| Category
|--------------------------------------------------------------------------
*/
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/category', [CategoryController::class, 'list']);
Route::get('/category_all', [CategoryController::class, 'showAll']);
Route::get('/category_add', [CategoryController::class, 'add']);
Route::post('/category_insert', [CategoryController::class, 'insert']);
Route::post('/category_update', [CategoryController::class, 'update']);
Route::get('/category_edit/{id}', [CategoryController::class, 'edit']);
Route::get('/category_edit_data/{id}', [CategoryController::class, 'edit_response']);
Route::get('/category_delete/{id}', [CategoryController::class, 'delete']);
/*
|--------------------------------------------------------------------------
| Category
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Teams
|--------------------------------------------------------------------------
*/
Route::get('/teams', [TeamController::class, 'index']);
Route::get('/team_add', [TeamController::class, 'add']);
Route::get('/team_edit/{id}', [TeamController::class, 'edit']);
/*
|--------------------------------------------------------------------------
| Teams
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Matches
|--------------------------------------------------------------------------
*/
Route::get('/matches', [MatchController::class, 'index']);
Route::get('/match_add', [MatchController::class, 'add']);
Route::get('/match_edit/{id}', [MatchController::class, 'edit']);
Route::get('/match_result', [MatchController::class, 'annoucement']);
Route::get('/match_prize/{id}', [MatchController::class, 'match_prize']);
//ChanpionSHip
Route::get('/championship', [MatchController::class, 'championship']);
Route::get('/championship_add', [MatchController::class, 'championship_add']);
Route::post('/championship_insert', [MatchController::class, 'championship_insert']);
Route::post('/championship_update', [MatchController::class, 'championship_update']);
Route::get('/championship_edit/{id}', [MatchController::class, 'championship_edit']);
//ScoreUpdate
Route::get('/score_edit/{id}', [MatchController::class, 'score_edit']);
Route::post('/score_update', [MatchController::class, 'score_update']);
//ScoreUpdate
//Update Withdraw Request
Route::get('/withdraw_edit/{withdraw_id}/{id}', [MatchController::class, 'withdraw_edit']);
Route::post('/widthdraw_update', [MatchController::class, 'widthdraw_update']);
//Update Withdraw Request
//ChanpionSHip

/*
|--------------------------------------------------------------------------
| Matches
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Betting Controller
|--------------------------------------------------------------------------
*/
Route::get('/bettings', [BettingController::class, 'index']);
Route::get('/betting_add', [BettingController::class, 'add']);
Route::get('/betting_edit/{id}', [BettingController::class, 'edit']);
/*
|--------------------------------------------------------------------------
| Betting Controller
|--------------------------------------------------------------------------
*/
Route::get('/points', [PointController::class, 'index']);
// Route::get('/betting_add', [PointController::class, 'add']);
Route::get('/point_view/{id}', [PointController::class, 'view']);
Route::get('/withdraw', [PointController::class, 'withdraw']);
Route::get('/withdraw_view/{id}', [PointController::class, 'withdraw_view']);
/*
|--------------------------------------------------------------------------
| Betting Controller
|--------------------------------------------------------------------------
*/

