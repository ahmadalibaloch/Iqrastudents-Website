<?php
session_start();

define('NL', "\n");
define('DS', DIRECTORY_SEPARATOR);
define('FW_ROOT', dirname(__FILE__).DS);
define('CONTROLLERS', APP_ROOT.'controllers'.DS);
define('VIEWS', APP_ROOT.'views'.DS);
define('MODELS', APP_ROOT.'models'.DS);

if(!defined('APP_URL')) trigger_error('APP_URL (application URL) not defined.');
if(!defined('APP_ENV')) define('APP_ENV', 'production');
if(!defined('CONTR_INDEX')) define('CONTR_INDEX', 1);

require(FW_ROOT.'functions.php');

class App extends Object
{
	var $request;
	static $instances;
		
	function run()
	{
		$con = $this->request->getController();
		$con::display($this->request->getAction(), $this->request->getParameters());
	}
	
	function render($name, $action, $view)
	{
		if(isset($this->instances[$name]->data[$action]))
		{
			foreach($this->instances[$name]->data[$action] as $k=>$v) $$k = $v;
		}
		
		require($view);		
	}
	
	function set($name, $action, $key, $value)
	{
		$this->instances[$name]->data[$action][$key] = $value;
	}
	
	static function start()
	{
		$app = new App();
		$app->request = Request::getInstance();
		$app->run();		
	}
	
	static function getInstance($name)
	{
		if(!isset(self::$instances[$name]))
		{
			$i = new $name();
			$i->name = $name;
			self::$instances[$name] = $i;
		}
		
		return self::$instances[$name];
	}
}