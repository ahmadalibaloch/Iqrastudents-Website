<?php
class LiteralFormType extends FormType
{	
	function htm($attr='')
	{		
		return '<span '.$attr.'>'.$this->getValue().'</span>';
	}
	
	function posted()
	{
		return $this->getValue();
	}
}