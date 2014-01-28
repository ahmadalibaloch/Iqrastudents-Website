<?php
class CheckboxFormType extends FormType
{
	private $vals = array();
	
	function init(array $vals)
	{
		$this->vals = $vals;
	}
	
	function htm($attr='')
	{
		$r = '';
		foreach($this->vals as $k=>$v) $r .= '<input type=checkbox name='.$this->htm_name.'['.$k.'] id='.$this->htm_name.'_'.$k.' value=1'.(isset($this->value[$k])?' checked':'').'><label for='.$this->htm_name.'_'.$k.'>'.$v.'</label>';
		return $r;
	}
}