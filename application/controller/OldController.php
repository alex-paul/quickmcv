<?php

class OldController extends system\FMVC_Controller
{
	public function init() {
		$this->loadExtension('form');
	}
	
	public function indexAction ()
	{
		
		
	}
	
	public function testAction()
	{
		
		/* example how to use service locator
		 * $oServiceLocator = \system\FMVC::getServiceLocator();
		$oDb = $oServiceLocator::getService('db');
		var_dump($oDb);
		 * 
		 */
		
				
		
		$this->render(null, null, 
			array (
				'var1' => $this->params[0],
				'var2' =>  'val2'
			)
		);
	}

}
