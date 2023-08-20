<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
    // return $request->user()->name;
    // return $request->user()->id;
    // return $request->user()->email;
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function(){
    Route::resource('products', 'Api\ProductController');
    Route::post('/logout', [AuthController::class, 'logout']);
});




// To get user from $request, it should pass through auth:api middleware check
Route::get('/testdata', function(Request $request){
    return response()->json($request->user());
})->middleware('auth:api');


// For exsting user with userid
Route::get('/createToken/{userId}', function($userId){
    $user = User::find($userId);
    if(is_null($user)){
        return response()->json([
            "message" => "User not found with id {$userId}"
        ]);
    } else {
        $token = $user->createToken('api')->accessToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }
});



// ## api testing postman routes
// http://local.laravel58.com:8181/api/testdata
// http://local.laravel58.com:8181/api/user
// http://local.laravel58.com:8181/api/createToken/3


