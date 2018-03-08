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

// Create Category
$router->post('createCategory/{categoryname}/{categorycolor}', 'CategoryController@CreateCategory');

// Get Id users
$router->post('getIDUser/{userToken}', 'UserController@GetUserID');


$router->get('login', function() {
    return 'hackathons';
});

//CRUD USERS
//$router->get('/api/user', 'UserController@index');
$router->get('/api/user', function(){
    return DB::select('SELECT * FROM users');
});

$router->get('api/user/{id}','UserController@getuser');

$router->post('signin/{username}/{email}/{password}','UserController@saveUser');

$router->post('admin/update/{username}/{password}/{newPassword}/{newUsername}/{newEmail}','UserController@updateUser');

$router->delete('api/user/{id}','UserController@deleteUser');
