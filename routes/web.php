<?php

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


$router->group(['prefix' => 'api'], function () use ($router) {

  // show all developers
  $router->get('developers',  ['uses' => 'DeveloperController@showAllDevelopers']);

  // show one developer
  $router->get('developers/{id}', ['uses' => 'DeveloperController@showOneDeveloper']);

  // list by categories
  $router->get('/category/{id}', ['uses' => 'DeveloperController@showAllDevelopersByCategory']);

  // create
  $router->post('developers', ['uses' => 'DeveloperController@create']);

  $router->post('category/{id}', ['uses' => 'DeveloperController@addToCategory']);

  //delete
  $router->delete('developers/{id}', ['uses' => 'DeveloperController@delete']);

  //update
  $router->put('developers/{id}', ['uses' => 'DeveloperController@update']);
});
