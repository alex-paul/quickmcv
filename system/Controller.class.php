<?php
namespace system;

class FMVC_Controller
{
	public $name;
	public $params;
	public $view;
	public $layout;
	public $content;
	private $_serviceLocator;
	
	public function init()
	{
		
	}
	
	public function loadExtension($sExtensionName) {
		if(!isset($sExtensionName) && !is_string($sExtensionName)) {
			throw new FMVC_Exception('Invalid extension name specified.');
		}
		
		$sExtensionFileName = '../system' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . $sExtensionName . DIRECTORY_SEPARATOR . ucfirst($sExtensionName) . '.extension.php';		
		
		if(!file_exists($sExtensionFileName)) {
			throw new FMVC_Exception('The specified extension not found in the library.');
		}
		require_once $sExtensionFileName;
	}
	
	public function __construct($name, $params)
	{
		
		$this->name = $name;
		$this->params = $params;		
		$this->init();
		$this->layout = '../application' . DIRECTORY_SEPARATOR. 'view' . DIRECTORY_SEPARATOR. 'layout' . DIRECTORY_SEPARATOR . 'default.phtml';
		
		
	}
	
	
	
	public function render( $view = null, $path = null, $data = array() )
	{
	
		
		$app = FMVC::getInstance();
		$action = $app->route['action'];
		
		
		if(!$path)
			$path = $this->name;
		
		
		if(!$view)
		{
			$this->view = $path . '/' . $action;
		}
		else {
			$this->view = $path. '/' .$view;
		}
		
		$view_file_path = '../application/view/' . $this->view . '.phtml';
		
		if(!file_exists($view_file_path))
		{
			throw new FMVC_Exception('The specified view file does not exist or the default was not created.');
		}
		
		
		
		if( !is_array ( $data ) ) 
		{
			throw new FMVC_Exception('The parameters provided should be put into an array. [ ex: $this->render("index", "new_skin", array ("var1"=> "val1")  )]');
		}
		elseif( count ($data) >= 1 )
		{
			
			foreach( $data as $key => $val)
			{				
				$$key = $val;
			}
			
			
		}
				
		ob_start();                      // start capturing output
		require_once($view_file_path);
		$this->content = ob_get_contents();    // get the contents from the buffer
		$used_vars = get_defined_vars();
		ob_end_clean();   
		
		
		require $this->layout;
	}
	
	
}
