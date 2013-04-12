<?php
error_reporting(E_ALL);
ini_set('error_reporting', 'On');

$request_uri = $_SERVER['REQUEST_URI'];

$route_elements = explode('/', $request_uri);
$route_elements = array_filter($route_elements);

$route = 'index';
$action = 'index';
$params = array();

if(count ($route_elements) == 1 )
{
	$route = array_shift($route_elements);	
}
elseif( count ($route_elements) == 2)
{
	$route = array_shift($route_elements);
	$action = array_shift($route_elements);		
}
elseif( count ($route_elements) > 2 )
{
	$route = array_shift($route_elements);
	$action = array_shift($route_elements);
	$params = $route_elements;
}

$route_array = array (
	$route => array(
		'controller' => $route,
		'action' => $action,
		'params' => $params
	)
);

$routes = array (
	 'custom' => array (
	 	'controller' => 'mycontroller',
	 	'action' => 'myaction',
	 	'params' => array()
	 ),
	 
	
	'test' => array(
		'controller' => 'test',
		'action' => 'index', 
		'params' => array (
			'1', '22', 'test'
		)
	)
);



if( array_key_exists($route, $routes))
{
	$route_array = $routes($route);
}




