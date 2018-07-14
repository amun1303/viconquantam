<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('/hospital', HospitalController::class);
    $router->resource('/survey', SurveyFormController::class);
    $router->get('/api/hospitals', 'HospitalController@hospitals');
    $router->get('/api/cities', 'CityController@cities');


});
