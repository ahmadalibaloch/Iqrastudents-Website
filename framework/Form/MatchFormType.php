<?php
class MatchFormType extends FormType
{	
	public $match_type;
	
	function init($match_type)
	{
		$match_type = $this->form->types[$match_type];
		$this->match_type = $match_type;
	}
	
	function htm($attr='')
	{
		$t = clone $this->match_type;
		$t->setValue($this->getValue());
		$t->error = null;
		$t->htm_name = $this->htm_name;
		return $t->htm($attr).$this->errorHtm();
	}
	
	function validate($value)
	{
		if($this->match_type->getValue() !== $value)
		{
			return $this->name.' must match '.$this->match_type->name;
		}
	}
}