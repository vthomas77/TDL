<?php
use DB;
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
//CRUD USERS
*/
$router->get('/api/user', function(){
    return DB::select('SELECT * FROM users');
});

//C
$router->post('signin/{username}/{email}/{password}','UserController@saveUser');

//R
$router->post('admin/read_account/{token}','UserController@readUser');
 
//U
$router->post('admin/update/{token}/{newPassword}/{newUsername}/{newEmail}','UserController@updateUser');

//D
$router->post('admin/remove_user/{username}','UserController@deleteUser');

/*
//Auth user     
*/

$router->get('login/{username}/{password}', 'UserController@authUser');
