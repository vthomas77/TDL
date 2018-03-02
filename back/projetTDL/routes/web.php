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

// Get Id users
$router->post('getIDUser/{userToken}', 'UserController@GetUserID');


$router->get('login', function() {
    return 'hackathons';
});

//To manage users CRUD
//$router->get('/api/user', 'UserController@index');
$router->get('/api/user', function(){
    $render = BD::select('SELECT * FROM users');
    return $render;
});

$router->get('api/user/{id}','UserController@getuser');

$router->post('signin/','UserController@saveUser');

$router->put('api/user/{id}','UserController@updateUser');

$router->delete('api/user/{id}','UserController@deleteUser');
