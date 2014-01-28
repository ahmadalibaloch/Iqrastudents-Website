<?php
function __autoload($class_name)
{
	$file1 = FW_ROOT.$class_name.'.php';
	$file2 = CONTROLLERS.$class_name.'.php';
	$file3 = MODELS.$class_name.'.php';
		
	if(is_file($file1)) require($file1);
	elseif(is_file($file2)) require($file2);	
	elseif(is_file($file3)) require($file3);	
}

function db()
{
	return Database::getInstance();
}

function fdate($date, $time = false)
{
	$tf = $time ? ' h:i:s A' : '';
	return date('d F, Y'.$tf, strtotime($date));
}

function trace($v)
{
	echo '<pre>';
	if($v && !is_bool($v)) print_r($v);
	else var_dump($v);
	echo '</pre>';
}

function parse_id($param)
{
	$matches = array();
	preg_match('/(\d+)$/', $param, $matches);
	if(isset($matches[1])) return $matches[1];
	return 0;
}

function url($controller = 'default', $action = 'default', array $params = array())
{
	$controller = $controller == 'default' ? '' : $controller.'/';
	$action = $action == 'default' ? '' : $action.'/';
	$params = $params ? implode('/', $params).'/' : '';
	
	return APP_URL.$controller.$action.$params;
}

function encode_param($parameter)
{
	$parameter = preg_replace('/\s+/','-', $parameter);
	$parameter = str_replace('/','-', $parameter);
	$parameter = str_replace('#','', $parameter);
	$parameter = preg_replace('/\-+/','-', $parameter);
	return $parameter;
}
function rand_limit_rows(array &$rows, $limit=0, $mix = true)
{
	if(($cnt = count($rows)) == 0) return $rows;

	if($limit == 0 || $limit > $cnt) $limit = $cnt;

	$keys = array_rand($rows, $limit);
	$r_rows = array();

	if(is_array($keys))
	{
		foreach($keys as $key)
		{
			$r_rows[] = $rows[$key];
		}

		if($mix) shuffle($r_rows);
	}
	else
	{
		$r_rows[] = $rows[$keys];
	}

	return $r_rows;
}
function group_by_property($obj_arr, $property)
{
	$r = array();
	$curr = '';
	$prev = '';

	foreach($obj_arr as $obj)
	{
		if($obj->$property == false) continue;
		$curr = $obj->$property;
		if($curr != $prev) $r[$curr] = '';
		if(isset($r[$curr])) $r[$curr][] = $obj;
		$prev = $curr;
	}

	return $r;
}

function check_url($url)
{
	if(preg_match('/^https?:\/\/[a-z0-9-]+(\.[a-z0-9-]+)+/i', $url)) return true;
	return false;
}

function set_public_root($file)
{
	define('PUB_ROOT', dirname($file).DS);
}

function arr($arr, $key, $def = null)
{
	return isset($arr[$key]) ? $arr[$key] : $def;
}

function redirect($url)
{
	if(Request::isAjax())
	{ 
		echo $url; exit;
	}
	
	header('Location: '.$url); exit;
}

function json_filter($str)
{
	return preg_replace('/:/', "\:", $str);
}