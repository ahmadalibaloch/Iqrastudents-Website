<?php

class Sorter
{
	public $sort, $order;
	private $url;
	private $sorts;
	
	function __construct(array $sorts)
	{
		$this->sorts = $sorts;
		$this->sort = $this->getSort();
		$this->order = $this->getOrder($this->sort);
		$this->setUrl(array('sort'=>$this->sort, 'order'=>$this->order));		
	}
	
	function getSort()
	{
		return (isset($_GET['sort']) && isset($this->sorts[$_GET['sort']])) ? $_GET['sort'] : key($this->sorts);
	}
	
	function getOrder($sort)
	{
		return isset($_GET['order']) && $this->sort == $sort ? ($_GET['order'] == 'desc' ? 'desc' : 'asc') : $this->sorts[$sort];
	}
	
	function currentOrder($sort)
	{
		return $this->sort == $sort ? $this->order : '';
	}
	
	function getNextOrder($sort)
	{
		return ($order = $this->currentOrder($sort)) ? ($order == 'desc' ? 'asc' : 'desc') : $this->sorts[$sort];
	}
	
	function getUrl($sort)
	{
		$order = $this->getNextOrder($sort);
		$url = preg_replace('/\/sort=\w+/', '/\1sort='.$sort, $this->url);
		return preg_replace('/\/order=\w+/', '/\1order='.$order, $url);
	}
	
	private function setUrl($sorts)
	{
		$request = Request::getInstance();

		$request = Request::getInstance();
		$this->url = build_url($request->getControllerName(), $request->getActionName(), $request->getParameters());	
		foreach($_GET as $key=>$value) if(false == isset($sorts[$key])) $this->url .= $key.'='.$value.'/';	
		foreach($sorts as $key=>$value) if($value) $this->url .= $key.'='.$value.'/';
		return substr($this->url, 0, -1);
	}
}