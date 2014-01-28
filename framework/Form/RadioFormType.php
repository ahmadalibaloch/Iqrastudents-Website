<?php
class RadioFormType extends FormType
{
	private $vals = array();
	
	function init(array $vals)
	{
		$this->vals = $vals;
	}
	
	function htm($attr='')
	{
		$r = '';
		if($this->required == false) $r .= '<input type=radio name='.$this->htm_name.' id='.$this->htm_name.' value=none'.($this->form->posted==false || $this->getValue()=='none' ? ' checked ' : ' ').$attr.'><label for='.$this->htm_name.'>None</label>';
		
		$checked = $this->required && !$this->getValue();
		
		foreach($this->vals as $k=>$v)
		{
			$r .= '<input type=radio name='.$this->htm_name.' id='.$this->htm_name.'_'.$k.' value="'.$k.'"'.($checked || $this->getValue()==$k ? ' checked ' : ' ').$attr.'><label for='.$this->htm_name.'_'.$k.'>'.$v.'</label>';
			$checked = false;
		}
		
		return $r;
	}
}