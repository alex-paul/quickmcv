<?php
namespace system;

class Singleton
{	
	public static $application = null;
	
	public function __construct($route)
	{
		self::$application = new \stdClass();
		self::$application->route = $route;		
	}
	public function __clone ()
	{
		
	}
	
	public static function getInstance()
    {
        if (!isset(static::$application)) {
            static::$application = new static;
        }
        return self::$application;
    }
	
	public static function setServiceLocator(ServiceLocator $oServiceLocator)
	{
		if(!$oServiceLocator instanceof ServiceLocator) {
			throw new \system\FMVC_Exception('Ivalid parameter provided for setting the service locator.');
		} else {
			$application = self::getInstance();
			$application->_serviceLocator = $oServiceLocator;
		}
	}
	
	public static function getServiceLocator()
	{
		if (isset(self::$application->_serviceLocator)) {
			return self::$application->_serviceLocator;	
		} else {
			throw new \system\FMVC_Exception('The service locator hasn\'t been set');
		}
	}
	
}
