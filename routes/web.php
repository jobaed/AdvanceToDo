<?php


use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */


// User Authentication Pages
Route::get( '/login', [UserController::class, 'loginPage'] );

Route::get( '/registration', [UserController::class, 'regiPage'] );

Route::get( '/otp', [UserController::class, 'otpPage'] );

Route::get( '/verify', [UserController::class, 'verifyotpPage'] )
->middleware([AfterLoginMiddleware::class]);

Route::get( '/reset', [UserController::class, 'resetPassPage'] )
    ->middleware( [TokenVerificationMiddleware::class] );






// Dashboard Pages
Route::get( '/dashboard', [UserController::class, 'dashboardPage'] )
    ->middleware( [TokenVerificationMiddleware::class] );
Route::get( '/profile', [UserController::class, 'ProfilePage'] )
    ->middleware( [TokenVerificationMiddleware::class] );











// For Api Call

// User Registration
Route::post( '/userApiData', [UserController::class, 'storeAPIData'] );

// User Login
Route::post( '/userLogin', [UserController::class, 'userLogin'] );

// Send Otp To reset Password
Route::post( '/sendOTPCode', [UserController::class, 'SendOTPCode'] );

// Verified Otp
Route::post( '/verifiedOTP', [UserController::class, 'VerifiedOTP'] );

// TOken Verification
Route::post( '/pass-reset', [UserController::class, 'ResetPass'] );

// Log Out User
Route::get( '/logout', [UserController::class, 'logOut'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// User Profile Data
Route::get( '/user-profile', [UserController::class, 'UserProfile'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// User Profile Update
Route::post( '/userUdate', [UserController::class, 'userUdate'] )
    ->middleware( [TokenVerificationMiddleware::class] );













// TODO Module


Route::get('/todo', [TodoController::class, 'showPage'])
->middleware( [TokenVerificationMiddleware::class] );

// Create
Route::post( '/create-todo', [TodoController::class, 'CreateToDo'] )
    ->middleware( [TokenVerificationMiddleware::class] );

//  UnCompleted todo Read
Route::get( '/list-todo', [TodoController::class, 'TodoList'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Update
Route::post( '/update-todo', [TodoController::class, 'UpdateTodo'] )
    ->middleware( [TokenVerificationMiddleware::class] );

// Delete
Route::post( '/delete-todo', [TodoController::class, 'DeleteTodo'] )
    ->middleware( [TokenVerificationMiddleware::class] );


// Complete Route
Route::post( '/uncomplete-todo', [TodoController::class, 'uncomplete'] )
    ->middleware( [TokenVerificationMiddleware::class] );


// Completed todo Read
Route::get( '/complete-todo', [TodoController::class, 'completeList'] )
->middleware( [TokenVerificationMiddleware::class] );


// Completed todo Read
Route::get( '/finish-todo', [TodoController::class, 'finishedPage'] )
->middleware( [TokenVerificationMiddleware::class] );

// Completed todo Read
Route::get( '/limit-todo', [TodoController::class, 'limitedTodo'] )
->middleware( [TokenVerificationMiddleware::class] );

