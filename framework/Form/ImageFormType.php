<?php
include_once('FileFormType.php');

class ImageFormType extends FileFormType
{	
	function init($size, $dir)
	{
		parent::init('image', $size, $dir);
	}

	function htm($attr='')
	{
		$v = $this->getValue();
		$v = $v ? '&nbsp;<image src="'.APP_URL.$this->dir.$v.'" width=100><br>' : '';
		return $v.parent::htm($attr);
	}	
}