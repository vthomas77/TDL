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
$router->post('createCard/{userToken}/{title}/{priority}/{category}/{deadline}/{status}', 'CardController@CreateCard');

// Get Card
//$router->post('getCard/{userToken}', ['middleware'=>'Tok','uses'=>'CardController@GetCard']);
$router->post('getCard/{userToken}/{cardFilter}', 'CardController@GetCard');
// Create Category
$router->post('createCategory/{categoryname}/{categorycolor}', 'CategoryController@CreateCategory');

// Get Id users
$router->post('getIDUser/{userToken}', 'UserController@GetUserID');

// Delete Card
$router->post('deleteCard/{userToken}/{cardID}', 'CardController@DeleteCard');

// Share Card
$router->post('shareCard/{cardID}', 'CardController@ShareCard');

// Search users
$router->post('searchUsers/{searchInput}', 'UserController@SearchUsers');

// Get Id users
$router->post('getIDUser/{userToken}', 'UserController@GetUserID');

// Update collaborators
$router->post('updateCollaborators', 'CardController@UpdateCollaborators');

// Upload image
$router->post('uploadImg', 'UserController@UploadImg');

// Task completion
$router->post('taskCompletion/{taskID}/{taskStatus}', 'TaskController@UpdateTaskCompletion');

/*
//Auth user
*/
$router->get('login/{username}/{password}', 'UserController@authUser');

/*
//CRUD USERS
*/
//$router->get('/api/user', function(){
//    return DB::select('SELECT * FROM users');
//});

//C
$router->post('signin/{username}/{email}/{password}/{avatar}','UserController@saveUser');


//group concerned by middleware : TokenMiddleware AND MainMiddleware
$router->group(['prefix' => 'admin', 'middleware' => ['App\Http\Middleware\TokenMiddleware', 'App\Http\Middleware\MainMiddleware']], function () use ($router) {
    //R user
    $router->post('read_account/{token}','UserController@readUser');

    //U user
    $router->post('update/{token}/{newPassword}/{newUsername}/{newEmail}','UserController@updateUser');

    //D user
    $router->post('remove_user/{username}/{token}','UserController@deleteUser');

    //C task
    $router->post('createTask/{token}/{taskName}/{rank}/{idCard}', 'TaskController@createTask');

    //R task
    $router->post('readTask/{token}/{idCard}', 'TaskController@readTask');

    //D task
    $router->post('dropTask/{token}/{idTask}', 'TaskController@dropTask');
});
