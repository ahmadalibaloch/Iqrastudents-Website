<?php
class FormType extends Object
{
	public $required, $form, $name, $htm_name, $error;
	
	function __construct($form, $name, $required)
	{
		$this->form = $form;
		$this->name = $name;
		$this->htm_name = preg_replace('/\s+/', '_', $name);
		$this->required = $required ? 'required' : '';		
	}
	
	function getValue()
	{
		return isset($_SESSION['forms'][$this->form->name][$this->name]) ? $_SESSION['forms'][$this->form->name][$this->name] : '';
	}
	
	function setValue($value)
	{
		$_SESSION['forms'][$this->form->name][$this->name] = $this->value = $value;
	}
	
	function errorHtm()
	{
		if($this->error) return '<br><span class=error>'.ucfirst($this->error).'.</span>';
	}
	
	function init(){}
	
	function htm()
	{
		echo '<p>html method not implemented in '.get_called_class().'</p>';
	}
	
	function posted()
	{
		return isset($_POST[$this->htm_name]) ? $_POST[$this->htm_name] : $this->getValue();
	}
	
	function required($value)
	{
		return $this->required && $value === '';
	}
	
	function validate($value){}
	
	static function instance($form, $name, $type, $required, array $values)
	{					
		$a = explode('|', $type);
		$t = ucfirst($a[0]).'FormType';
		array_shift($a);
		if($values) $a[] = $values;
		
		include_once($t.'.php');
		
		$t = new $t($form, $name, $required);
		$rm = new ReflectionMethod($t, 'init');
		$rm->invokeArgs($t, $a);
		
		return $t;
	}
}