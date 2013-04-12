<?php 
namespace system;

class FMVC_Exception extends \Exception 
{
	public function __construct($message)
	{
		echo '<h1>' .$message.'</h1>';
		die();
	}
}
