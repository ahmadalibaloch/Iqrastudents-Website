<?php
include_once('TextFormType.php');

class PasswordFormType extends TextFormType
{
	function init($range='')
	{
		parent::init('text', $range);
	}
	
	function htm($attr='')
	{		
		return '<input type=password name='.$this->htm_name.' value="'.$this->getValue().'" '.$attr.' '.$this->required.'>'.$this->errorHtm();
	}
	
	function validate($value)
	{
		if($this->min && preg_match('/[^a-z0-9]+/i', $value) == false)
			return $this->name.' must contain one or more non-alphanumeric charactor';
		else
			return $this->range(strlen($value), ' charactors');
	}
}