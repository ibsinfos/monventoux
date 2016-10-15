<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('', 'PageController@getFrontPage');
// login / register
Route::get('login', 'UserController@getLogin');
Route::post('login', 'UserController@postLogin');
Route::get('inschrijven', 'UserController@getRegister');
Route::post('inschrijven', 'UserController@postRegister');
Route::get('bevestiging', 'UserController@confirmation');
Route::get('logout', 'UserController@getLogout');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postUsername');
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// pages
Route::get('/programma/{program}', 'PageController@getProgram');
Route::get('/programma/{program}/{path}', 'PageController@getProgram');
Route::get('/p/{path}', 'PageController@getPage');
Route::get('/p/{path}/{subpath}', 'PageController@getPage');
Route::get('/voorbereiden/{path}', 'PageController@getPreparePage');
Route::get('/voorbereiden/{path}/info', 'PageController@getPreparePage');
Route::get('/voorbereiden/{path}/info/{id}', 'PageController@getPreparePage');
Route::get('/voorbereiden/{path}/inschrijven', 'PageController@getPrepareSubscribe');
Route::get('/voorbereiden/{path}/inschrijven/{id}', 'PageController@getPrepareSubscribe');
Route::post('/voorbereiden/{path}/inschrijven/{id}', 'PageController@postPrepareSubscribe');
Route::get('/nieuws', 'PageController@getNews');

// volunteers
Route::get('/vrijwilliger', 'VolunteerController@showForm');
Route::post('/vrijwilliger', 'VolunteerController@postForm');

// outfit
Route::get('/webshop/producten', 'WebshopController@index');
Route::get('/webshop/bestellen', 'WebshopController@create');
Route::post('/webshop/verstuur', 'WebshopController@store');

//photocontest
Route::get('/fotowedstrijd/inzendingen', 'PhotocontestController@index');
Route::get('/fotowedstrijd', 'PhotocontestController@create');
Route::post('/fotowedstrijd/store', 'PhotocontestController@store');
Route::get('/fotowedstrijd/bedankt', 'PhotocontestController@thanks');

// api
Route::post('/mv16api/newsletter', 'APIController@postNewsletter');

// foto's flickr
Route::get('/eventfotos/', 'FlickrController@getSets');
Route::get('/eventfotos/{id}', 'FlickrController@getSet');

// Livestreams
Route::get('/livestream/{location}', 'LivestreamController@getStream');

// pages you need to be logged in for
Route::group(['middleware' => 'auth'], function () {
    Route::get('home', 'UserController@home');
    Route::get('tijden', 'TimingController@index');
    Route::get('tijden/pdf', 'TimingController@makePDF');
    Route::get('tijden/diploma', 'TimingController@diploma');
    Route::get('klassement', 'TimingController@ranking');
    Route::get('toeristische-gids', 'UserController@touristicGuide');
    Route::get('downloadcorner', 'UserController@downloadCorner');
    Route::get('programma', 'UserController@showProgram');
    Route::get('gebruiker', 'UserController@index');
    Route::post('gebruiker', 'UserController@editUser');
    Route::get('medischattest', 'UserController@showCertificate');
    Route::get('testdagenformulier', 'TestingdaysSubscriptionsController@showTestingdaysForm');
    Route::post('testdagenformulier', 'TestingdaysSubscriptionsController@postTestingdaysForm');
});
// admin pages
Route::group(['middleware' => 'auth.admin'], function () {
    Route::get('admin/mails', 'UserController@showImportedMembers');
    Route::post('admin/mails', 'UserController@hashAndMail');
    Route::get('mediamanager', 'mediamanagerController@index');
    Route::get('admin/nieuwsbeheer', 'NewsController@index');
    Route::get('admin/nieuwsbeheer/create', 'NewsController@create');
    Route::get('admin/nieuwsbeheer/{id}', 'NewsController@show');
    Route::get('admin/nieuwsbeheer/{id}/edit', 'NewsController@edit');
    Route::post('admin/nieuwsbeheer/{id}/edit', 'NewsController@update');
    Route::post('admin/nieuwsbeheer', 'NewsController@store');
    Route::get('admin/quotebeheer', 'QuoteController@index');
    Route::get('admin/quotebeheer/create', 'QuoteController@create');
    Route::get('admin/quotebeheer/{id}', 'QuoteController@show');
    Route::get('admin/quotebeheer/{id}/edit', 'QuoteController@edit');
    Route::post('admin/quotebeheer/{id}/edit', 'QuoteController@update');
    Route::post('admin/quotebeheer', 'QuoteController@store');
});
