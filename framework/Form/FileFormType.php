<?php
class FileFormType extends FormType
{
	public $type, $size, $dir, $root;

	function init($type, $size, $dir, $root = PUB_ROOT)
	{
		$this->type = $type;
		$this->size = $size;
		$this->dir = $dir;
		$this->root = $root;
	}

	function htm($attr='')
	{
		return '<input type=file name='.$this->htm_name.' '.$attr.'>'.$this->errorHtm();
	}

	function posted()
	{
		return arr($_FILES, $this->htm_name);
	}

	function required($file)
	{
		return $this->getValue() == '' && $this->required && $file['error'] == 4;
	}

	function validate($file)
	{
		switch($file['error'])
		{
			case 0:
				if(false == $this->type($file['type']))
					return 'file type mismatched';
				elseif($file['size'] > $this->size($this->size))
					return 'file size exceeds allowed limit ('.$this->size.')';
				else
				{
					$v = $this->upload($file, $this->root.$this->dir);
					if(null == $v) return 'file not uploaded';
					$this->setValue($v);
				}
				break;
			case 1:
			case 2:
				return 'file size exceeds allowed limit ('.ini_get('upload_max_filesize').')';
			case 3:
				return 'file not uploaded completely';
			case 6:
				return 'missing a temp folder on server';
			case 7:
				return ' failed to write file to disk';
			case 8:
				return 'a PHP extension stopped the file upload';
		}
	}

	function type($type)
	{
		switch($this->type)
		{
			case 'image':
				return preg_match('/image/', $type);
		}

		return false;
	}

	function upload($file, $dir)
	{
		$p = pathinfo($file['name']);
		$x = strtolower($p['extension']);
		$n = $nn = $p['filename'];
		$i = 2;
		while(file_exists($dir.$nn.'.'.$x)) $nn = $n.'_'.$i++;
		$nn .= '.'.$x;

		if(move_uploaded_file($file['tmp_name'], $dir.$nn))
		{
			if($v = $this->getValue()) @unlink($dir.$v);
			return $nn;
		}
	}

	function size($size)
	{
		$d = strtolower(substr($size, -1, 1));

		switch($d)
		{
			case 'k':
				return floatval($size) * 1024;
			case 'm':
				return floatval($size) * 1024 * 1024;
			default:
				return floatval($size);
		}
	}
}