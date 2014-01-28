<?php
include_once('Form/FormType.php');

class Form extends Object
{
	public $name, $key, $posted, $error, $upload;
	public $types = array();
	
	function __construct($name)
	{	
		if($_POST)
		{
			$k = isset($_SESSION['formkey'][$name]) ? $_SESSION['formkey'][$name] : '';
			$this->posted = isset($_POST['formkey']) && $k == $_POST['formkey'];
		}
		
		$this->name = $name;
		$this->key = $_SESSION['formkey'][$name] = rand(111111, 999999);
		$this->add('submit', 'submit');
	}
	
	function add($name, $type, $requied=false, array $values=array())
	{		
		$t = FormType::instance($this, $name, $type, $requied, $values);
		$this->upload = $this->upload === null && isset($t->dir) ? true : $this->upload;
		$this->types[$name] = $t;
		return $t;
	}
	
	function get($name)
	{
		return $this->types[$name]->getValue();
	}
	
	function htm($name, $attr='')
	{
		return $this->types[$name]->htm($attr);
	}
	
	function errorHtm()
	{
		if($this->error) return '<span class=error>'.$this->error.'</span>';
	}
	
	function fill(array $vals)
	{
		foreach($this->types as $n=>&$t) $t->setValue(isset($vals[$n]) ? trim($vals[$n]) : '');	
	}
	
	function validate()
	{
		if($this->posted == false) return false;
		
		$r = true;
		
		foreach($this->types as $n=>&$t)
		{
			$v = $t->posted();
			$e = null;
			if($t->required($v)) $e = ucfirst($n).' is requied';			
			elseif($v) $e = $t->validate($v);
			if($e) $t->setError($e);
			if(!isset($t->dir)) $t->setValue($v);
			if($t->getError() != null) $r = false;
		}
		
		return $r;
	}
	
	function start($attr='')
	{		
		return '<form method=post name='.$this->name.'_form id='.$this->name.'_form'.($this->upload ? ' enctype=multipart/form-data ' : ' ').$attr.'>';
	}
	
	function end()
	{		
		return '<input type=hidden name=formkey value='.$this->key.'></form>';
	}
	
	function clear()
	{
		unset($_SESSION['formkey'][$this->name]);
		unset($_SESSION['forms'][$this->name]);
	}
}