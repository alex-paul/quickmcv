<?php 

/**
 * @package FMVC
 * @author Alexandru Paul <rainelf@gmail.com>
 * @version 1.0
 */

class Form 
{
	private $_oForm;
	private $_validMethods = array ('post', 'get');
	private $_validInputTypes = array ('text', 'hidden', 'radio', 'checkbox', 'submit', 'image');
	public $sHtml;
	
	public function __construct($sMethod, $sAction = '', $aExtra)
	{
		if (!isset($sMethod) || !is_string($sMethod) || !in_array(strtolower($sMethod), $this->_validMethods) ) {
			throw new \system\FMVC_Exception("Invalid method specified");
		} else {
			$this->_oForm = new \stdClass();
			$this->_oForm->method = strtolower($sMethod);
			$this->_oForm->action = $sAction;
			$this->_oForm->extra = $aExtra;
		}	
	} 
	
	/**
	 * Method that writes the open tag for a form, including mehtod, action and several other parameters
	 * contained in the array $aExtra specified in the constructor.
	 */
	public function openForm() 
	{
		$this->sHtml = '<form';
		if (isset($this->_oForm->method)) {
			$this->sHtml .= ' method="' . $this->_oForm->method . '"';
		}
		if (isset($this->_oForm->action)) {
			$this->sHtml .= ' action="' . $this->_oForm->action . '"';
		}
		if (isset($this->_oForm->extra) && is_array($this->_oForm->extra)) {
			foreach ($this->_oForm->extra as $sAttribute => $sValue) {
				$this->sHtml .= ' ' . $sAttribute = '="' . $sValue . '"';
			}
		}
		$this->sHtml .= ">";	
		$this->printCurrentHtml();	
	}
	
	/**
	 * Method that writes the tag for closing the form.
	 */
	public function closeForm ()
	{
		$this->sHtml = '</form>';
		$this->printCurrentHtml();
		
	}
	
	/**
	 * @param $sType string
	 * @param $sName string
	 * @param $sValue string
	 * @param $aExtra array
	 * @param $bWriteInput bool
	 * 
	 * Method that creates an element for the current form. The input type must be a valid one, contained in
	 * $this->$_validInputTypes. 
	 * The $aExtra parameters provide an array of attributes that in the input might have.
	 * If $bWriteInput is set to true then the method also writes in the view file, the code that creates the input.
	 */
	public function addInput ($sType, $sName, $sValue = '', $aExtra = array(), $bWriteInput = FALSE)
	{		
		if (!isset($sType) || !is_string($sType) || !in_array($sType, $this->_validInputTypes)) {
			throw new \system\FMVC_Exception("Invalid type specified for the input.");
		}
		
		$oInput = new \stdClass();
		$oInput->type = $sType;
		
		if (!isset($sName) || !is_string($sName)) {
			throw new \system\FMVC_Exception("Invalid name specified for the input.");
		}
		
		$oInput->name = $sName;
		
		if (isset($aExtra) && is_array($aExtra)) {
			$oInput->extra = $aExtra;
		}
		
		if (!isset($this->_oForm->elements)) {
			$this->_oForm->elements = array();
		}
		
		$oInput->value = $sValue;
		
		$this->_oForm->elements[] = $oInput;
		
		if($bWriteInput === TRUE) {
			$this->sHtml = '<input type="' . $oInput->type . '" name="'.$oInput->name.'"';
			$this->sHtml .= ' value="'.$oInput->value.'"';
			
			if(is_array($oInput->extra)) {
				foreach($oInput->extra as $sKey => $sVal) {
					$this->sHtml .= ' ' . $sKey .= '="' . $sVal . '"';
				}
			}
			
			$this->sHtml .= ' />';
			$this->printCurrentHtml();
		}
		
		return $oInput;
	}

	
	/**
	 * @param $sName string
	 * @param $aOptions array
	 * @param $mValue mixed
	 * @param $aExtra array
	 * @param $bWriteInput bool
	 * 
	 * Method that adds a select box to the form, either drop down or multiple select.
	 * If $bWriteInput is set to true, then the method also writes (in the view file) the content of the input. 
	 */
	public function addSelect($sName, $aOptions = array(), $mValue = '', $aExtra = array(), $bWriteInput = FALSE)
	{
				
		if (!isset($sName) || !is_string($sName)) {
			throw new \system\FMVC_Exception("Invalid name specified for the input.");
		}
		
		$oInput = new \stdClass();
		$oInput->type = 'select';				
		$oInput->name = $sName;
		
		if (isset($mValue)) {
			$oInput->value = $mValue;
		}
		
		if (!isset($aOptions) || !is_array($aOptions)) {
			throw new \system\FMVC_Exception("Invalid options set specified for the input.");
		}
		
		$oInput->options = $aOptions;
		
		if (isset($aExtra) && is_array($aExtra)){
			$oInput->extra = $aExtra;
		}
		
		if (!isset($this->_oForm->elements)) {
			$this->_oForm->elements = array();
		}
		
		$this->_oForm->elements[] = $oInput;
		
		if ($bWriteInput === TRUE) {
			$this->sHtml = '<select name="'.$oInput->name.'"';
			
			if(isset($oInput->extra) && is_array($oInput->extra)) {
				foreach($oInput->extra as $sKey => $sVal) {
					$this->sHtml .= ' ' . $sKey .= '="' . $sVal . '"';
				}	
			}
			$this->sHtml .= '>';
			
			if (isset($oInput->options) && is_array($oInput->options)) {
				foreach ($oInput->options as $sKey => $sVal) {
					$this->sHtml .= '<option value="'.$sKey.'"';
					if (isset($oInput->value) && is_array($oInput->value)) {
						if (in_array($sVal, $oInput->value)) {
							$this->sHtml .= ' selected="selected"';
						} elseif(isset($oInput->value) && is_string($oInput->value)) {
							$this->sHtml .= ' selected="selected"';
						}
					}
					$this->sHtml .= '>' .$sVal . '</option>';
				}
			}
						
			$this->sHtml .= '</select>';
			$this->printCurrentHtml();
		}
		
		return $oInput;
	}
	
	/**
	 * Method used to print various parts of the form. Each element that is to be printed has the
	 * html in $this->sHtml property.
	 */
	public function printCurrentHtml() {
		echo $this->sHtml;	
	}
	
}
