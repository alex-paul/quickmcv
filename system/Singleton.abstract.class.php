<?php
namespace system;

abstract class Singleton
{
	public function __construct()
	{
		
	}
	public function __clone ()
	{
		
	}
	public static function getInstance()
	{
		if (!isset(self::$instance)) {
	    	self::$instance = new self;        
		}        
		return self::$instance;
	}
}
