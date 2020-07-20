<?php

$routes->group('',['namespace' => 'Rudi\App\Controllers\Authentication'],function($routes){
	
	$routes->get('login','Auth::login',['as' => 'login']);
	$routes->post('login','Auth::saveLogin');

	$routes->get('register','Auth::register',['as'=>'register']);
	$routes->post('register','Auth::saveRegister');

});