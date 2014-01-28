<?php
class Controller extends App
{
	public $layout, $action;
	
	static function display($action='defaultAction',array $parameters=array()){
		$c=self::getInstance();
		$c->action=$action;		
		if($l=$c->getLayout()){
			$l->beforeLoad($c,$action,$parameters);
			if(method_exists($c,'onLayoutLoad'))$c->onLayoutLoad($l,$action,$parameters);
		}		
		$r=self::fetch($action,$parameters);		
		if($l && $l->render){
			$l->set('body',$r);
			$l->afterLoad($c,$action,$parameters);
			$l->render();
		}
		else echo $r;
	}

	static function fetch($action='defaultAction',$parameters=null){
		$c=self::getInstance();
		$pa=$c->action;
		$c->action=$action;
		if(method_exists($c,$action)){			
			if(is_array($parameters) && $parameters){				
				$rm=new ReflectionMethod($c,$action);
				$r=$rm->invokeArgs($c,$parameters);
			}
			elseif($parameters){
				$r=$c->$action($parameters);
			}
			else $r=$c->$action();			
			$c->action=$pa;
			return $r;
		}
		else trigger_error('Method '.$c->name.'::'.$action.' does not exists.',E_USER_ERROR);
	}

	protected function view($view=null){
		if($view==null) $view=str_replace('Controller','',$this->name).'.'.str_replace('Action','',$this->action);
		$view=VIEWS.$view.'.phtml';
		ob_start();
		$this->render($this->name,$this->action,$view);
		return ob_get_clean();		
	}

	protected function getLayout(){
		if(Request::isAjax()) return null;		
		if($this->layout==null)$this->layout=DefaultLayout::getInstance();		
		return $this->layout;
	}

	function set($key,$value){
		parent::set($this->name,$this->action,$key,$value);
	}
	
	function error($error){
		$this->set('error',$error);
		return $this->view('error');
	}
	
	static function getInstance(){
		$n=get_called_class();
		return parent::getInstance($n);
	}
}