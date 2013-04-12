<?php

class OldController extends system\FMVC_Controller
{
		
	public function indexAction ()
	{
		
		
	}
	
	public function testAction()
	{
		//$this->render('custom_view','custom_subdir');
		//print_r($this);
		$this->render(null, null, 
			array (
				'var1' => $this->params[0],
				'var2' =>  'val2'
			)
		);
	}

}
