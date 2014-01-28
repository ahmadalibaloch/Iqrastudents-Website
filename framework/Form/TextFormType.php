<?php
class TextFormType extends FormType
{
	public $type, $min, $max;
	
	function init($type='', $range=',')
	{
		$this->type = $type;
		$a = explode(',', $range);
		$this->min = intval($a[0]);
		$this->max = intval(arr($a, 1));
	}
	
	function htm($attr='')
	{
		$d = $this->type == 'date' ? ' date="date"' : '';
		
		return '<input type=text name='.$this->htm_name.' value="'.$this->getValue().'" '.$attr.' '.$this->required.$d.'>'.$this->errorHtm();
	}
	
	function range($count, $append='')
	{
		if($this->min && $count < $this->min)
			return $this->name.' must be greater then or equal to '.$this->min.$append;
		elseif($this->max && $count > $this->max)
			return $this->name.' must be smaller then or equal to '.$this->max.$append;
	}
	
	function posted()
	{		
		$p = parent::posted();
		
		switch($this->type)
		{
			case 'date':				
				$r = strtotime($p);
				return $r > 0 ? date('Y-m-d', $r) : $p;
			default:
				return $p;
		}
	}
	
	function validate($value)
	{
		switch($this->type)
		{
			case 'text':
				return $this->range(strlen($value), ' charactors');
				break;
			case 'alphabetic':
				if(preg_match('/^([a-z]|\s|)+$/i', $value) == false)
					return $this->name.' must contain alphabetic charactors';
				else
					return $this->range(strlen($value), ' charactors');
				break;
			case 'alphanumeric':
				if(preg_match('/^[a-z0-9]+$/i', $value) == false)
					return $this->name.' must contain alphanumeric charactors';
				else
					return $this->range(strlen($value), ' charactors');
				break;
			case 'numeric':
				if(preg_match('/^[0-9]+$/', $value) == false)
					return $this->name.' must contain numeric charactors';
				else
					return $this->range(intval($value));
				break;
			case 'email':
				if(preg_match('/^([.0-9a-z_-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4})$/i', $value) == false)
					return $this->name.' is not valid e-mail address';
				break;
			case 'url':
				if(preg_match('/^https?:\/\/[a-z0-9-]+(\.[a-z0-9-]+)+/i', $value) == false)
					return $this->name.' is not valid web address';
				break;
			case 'date':
				$d = getdate(strtotime($value));				
				if($d[0] == 0 || checkdate($d['mon'], $d['mday'], $d['year']) == false)
					return $this->name.' is not valid date';
				break;
		}
	}
}