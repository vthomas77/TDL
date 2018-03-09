<?php
//use DB;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->get('/', function () use ($router) {    
    return $router->app->version();
});

// Create Card
$router->post('createCard/{userID}/{title}/{priority}/{category}/{deadline}/{status}', 'CardController@CreateCard');

// Get Card
$router->post('getCard/{userToken}', 'CardController@GetCard');

// Get Id users
$router->post('getIDUser/{userToken}', 'UserController@GetUserID');

/*
//Auth user     
*/
$router->get('login/{username}/{password}', 'UserController@authUser');

/*
//CRUD USERS
*/
$router->get('/api/user', function(){
    return DB::select('SELECT * FROM users');
});

//C
$router->post('signin/{username}/{email}/{password}','UserController@saveUser');

//group concerned by middleware : TokenMiddleware AND MainMiddleware
$router->group(['prefix' => 'admin', 'middleware' => ['App\Http\Middleware\TokenMiddleware', 'App\Http\Middleware\MainMiddleware']], function () use ($router) {
    //R
    $router->post('read_account/{token}','UserController@readUser');

    //U
    $router->post('update/{token}/{newPassword}/{newUsername}/{newEmail}','UserController@updateUser');

    //D
    $router->post('remove_user/{username}/{token}','UserController@deleteUser');
});



