<?php
class Layout extends App
{
	var $title;
	var $render = true;
	
	var $css = array();
	var $js = array();	
	
	function render()
	{
		$css = ''; $js = '';
		
		foreach($this->css as $path=>$include) if($include) $css .= "\t".'<link rel=stylesheet type="text/css" href="'.$path.'">'."\n";
		foreach($this->js as $path=>$include) if($include) $js .= "\t".'<script type="text/javascript" src="'.$path.'"></script>'."\n";
		
		$this->set('css', $css);
		$this->set('js', $js);
	
		$view = VIEWS.strtolower(substr($this->name,0,-6)).'.layout.phtml';
		parent::render($this->name, 'default', $view);
	}
	
	function set($key, $value)
	{
		parent::set($this->name, 'default', $key, $value);
	}
	
	function addCss($path)
	{
		$this->css[$path] = true;
	}

	function addJs($path)
	{
		$this->js[$path] = true;
	}
	
	function removeCss($path)
	{
		$this->css[$path] = false;
	}

	function removeJs($path)
	{
		$this->js[$path] = false;
	}
	
	static function getInstance()
	{
		$n = get_called_class();
		return parent::getInstance($n);
	}
}