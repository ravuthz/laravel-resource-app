<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

$authorizeServer = 'http://all-laravel-ravuthz.c9users.io:8081';
$currentSystem = 'http://all-laravel-ravuthz.c9users.io:8082';

Route::get('/redirect', function () use ($authorizeServer, $currentSystem) {
    $query = http_build_query([
        'client_id' => '4',
        'redirect_uri' => $currentSystem . '/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect($authorizeServer . '/oauth/authorize?' . $query);
})->name('get.token');

Route::get('/callback', function (Request $request) use ($authorizeServer, $currentSystem) {
    $http = new GuzzleHttp\Client;

    $response = $http->post($authorizeServer . '/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '4',
            'client_secret' => 's9cajLPMRy498RBdBoHf3nkrFDLqOczyOZsFpi7l',
            'redirect_uri' =>  $currentSystem . '/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

