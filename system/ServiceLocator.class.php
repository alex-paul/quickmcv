<?php
namespace system;
class ServiceLocator {
	
	public static $aServices = array ();
	
	public static function registerService($sServiceName, $obj)
	{		
		if (isset($sServiceName) && is_object($obj)) {
			if (is_array(self::$aServices) && !array_key_exists($sServiceName, self :: $aServices)) {
				self::$aServices[$sServiceName] = $obj;
			} else {
		          throw new \system\FMVC_Exception('Service ' . $sServiceName . ' already registered.');	
			}
		} else {
			throw new \system\FMVC_Exception('Invalid parameters provided for service registering.');
		}
	}
	
	public static function getService($sServiceName) 
	{
		if (isset($sServiceName) && is_string($sServiceName)) {
			if (is_array(self::$aServices) && array_key_exists($sServiceName, self :: $aServices)) {
				return self::$aServices[$sServiceName];
			}
		}
		
		/* service not found */
		throw new \system\FMVC_Exception('Service ' . $sServiceName . ' not found.');
		
	}
}
