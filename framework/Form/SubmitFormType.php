<?php
class SubmitFormType extends FormType
{	
	function htm($attr='')
	{
		return '<input type=submit name='.$this->name.' '.$attr.'>';
	}
}