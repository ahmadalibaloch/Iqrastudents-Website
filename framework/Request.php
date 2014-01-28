<?php
class Request extends Object
{
	var $controller;
	var $action;
	var $parameters =  array();
	static $isMobile;
	static $isAjax;
	static $instance;

	private function __construct()
	{
		$r = explode('/', $_SERVER['REQUEST_URI']);
		$i = CONTR_INDEX;

		if(isset($r[$i]) && ($c = ucfirst($r[$i]).'Controller'))
		{
			if(is_file(CONTROLLERS.$c.'.php')) unset($r[$i++]);
			else $c = 'DefaultController';
		}
		else $c = 'DefaultController';

		$this->controller = $c::getInstance();

		if(isset($r[$i]) && ($a = $r[$i].'Action'))
		{
			if(method_exists($this->controller, $a)) unset($r[$i++]);
			else $a = 'defaultAction';
		}
		else $a = 'defaultAction';

		$this->action = $a;

		$ps = array();

		foreach($r as $k=>$v)
		{
			if(preg_match('/(\w+)=(.*)/', $v, $m))
			{
				$_GET[$m[1]] = urldecode($m[2]);
			}
			elseif($k >= ($i) && $v) $this->parameters[] = $v;
		}
	}

	static function isMobile()
	{
		if(self::$isMobile === null)
		{
			$ma = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));
			$mas = array('w3c ','acs-','alav','alca','amoi','andr','audi','avan','benq','bird','blac','blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno','ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-','maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-','newt','noki','oper','palm','pana','pant','phil','play','port','prox','qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar','sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-','tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp','wapr','webc','winw','winw','xda','xda-');

			if(preg_match('/(android|up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
			{
				self::$isMobile = true;
			}
			elseif((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) || ((isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE']))))
			{
				self::$isMobile = true;
			}
			elseif(in_array($ma, $mas))
			{
				self::$isMobile = true;
			}
			elseif(isset($_SERVER['ALL_HTTP']) && strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini') > 0)
			{
				self::$isMobile = true;
			}

			if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') > 0)
			{
				self::$isMobile = false;
			}
		}

		return self::$isMobile;
	}

	static function isAjax()
	{
		if(self::$isAjax === null)
		{
			self::$isAjax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') || (isset($_POST['HTTP_X_REQUESTED_WITH']) && $_POST['HTTP_X_REQUESTED_WITH'] == 'IFrame');
		}

		return self::$isAjax;
	}
	static function getInstance()
	{
		if(self::$instance === null)
		{
			self::$instance = new Request();
		}

		return self::$instance;
	}
}