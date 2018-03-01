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
$router->post('createCard/{id_user}/{title}/{priority}/{category}/{deadline}', 'CardController@CreateCard');

/*
$router->post('createCard', function(){

  var_dump('heelo');
});
*/



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
