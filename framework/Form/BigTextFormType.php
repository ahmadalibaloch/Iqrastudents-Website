<?php
include_once('TextFormType.php');

class BigTextFormType extends TextFormType
{
	public $type, $min, $max;
	
	function init($type='', $range=',')
	{
		parent::init($type, $range);		
	}
	
	function htm($attr='')
	{
		return '<textarea name='.$this->htm_name.' '.$this->required.' '.$attr.'>'.$this->getValue().'</textarea>'.$this->errorHtm();
	}
}