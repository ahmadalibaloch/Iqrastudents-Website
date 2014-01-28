<?php
class SelectFormType extends FormType
{
	private $vals = array();
	
	function init(array $vals)
	{
		$this->vals = $vals;
	}
	
	function htm($attr='')
	{
		$r = '<select name='.$this->htm_name.' '.$attr.'>';
		if($this->required == false) $r .= '<option></option>';
		foreach($this->vals as $k=>$v) $r .= '<option value='.$k.($this->getValue()==$k?' selected':'').'>'.$v.'</option>';
		return $r.'</select>';		
	}
}