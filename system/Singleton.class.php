<?php
namespace system;

class Singleton
{	
	public static $application = null;
	
	public function __construct($route)
	{
		$application = new \stdClass();
		static::$application->route = $route;		
	}
	public function __clone ()
	{
		
	}
	
	public static function getInstance()
    {
        if (!isset(static::$application)) {
            static::$application = new static;
        }
        return static::$application;
    }
	
}
