<?php

namespace system;

require '../system/Singleton.class.php';


class FMVC extends Singleton
{
	
	
	public function __construct($route_array = null)
	{
		
		error_reporting(E_ALL);
		ini_set('display_errors', 'On');
		$route = array_shift($route_array);
		parent::__construct($route);
		/* 
		 * load the files within the system directory
		 */
		 $path = '../system/';
		 $dh = opendir($path);
		 $files = scandir($path);
		 
		 foreach($files as $item )
		 {
		 	if ( strstr($item,'.php')  != '' )
			{
				require_once '../system/' . $item;
			}
		 }
		 
		
		
		
	}
	
	public static function getApplication()
	{
		return self::$application;
	}
	public function run()
	{
		
				
		$controllers = scandir('../application/controller/');
		
	
		$controller_file = ucfirst( self::$application->route['controller']. 'Controller.php');
		
		if(! in_array ( $controller_file, $controllers ) )
		{
			throw new FMVC_Exception("The requested controller does not exist.");
			
		}
		else {
			require_once '../application/controller/' . $controller_file;
			$controller_name = ucfirst( self::$application->route['controller']. 'Controller' );
			if ( ! class_exists($controller_name ) )
			{
				throw new FMVC_Exception("Wrong class name in the requested controller.");
			}
			
			$action_name = self::$application->route['action']. 'Action' ;			
			if( ! method_exists( $controller_name , $action_name) )
			{
				throw new FMVC_Exception("Wrong method name in the requested controller.");
			}
			else
			{
				$params = self::$application->route['params'];				
				$obj = new $controller_name(self::$application->route['controller'], $params);				
				$obj->$action_name();		
			}
		}
		
		
		
	}
}
