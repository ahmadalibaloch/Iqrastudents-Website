<?php
class ImagesController extends Controller
{
	function usersAction($dim='', $image='')
	{
		//header('Content-Type
		if($l = $this->getLayout())	$l->render = false;
		$p = PUB_ROOT.'images/users/'.urldecode($image);
		return file_get_contents($p);
	}
}
