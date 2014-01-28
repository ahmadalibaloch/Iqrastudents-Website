<?php
class DefaultController extends Controller
{
	function defaultAction()
	{
		if($logdUser = User::getLoggedIn())
		{
			return $this->view('Default.aboutiso');
		}
		
		return $this->view();
	}
	
	function ourworkAction()
	{
		return $this->view();
	}
	
	function aboutisoAction()
	{
		return $this->view();
	}
	
	function leftPanelAction()
	{
		$logdUser = User::getLoggedIn();
		
		$this->set('logdUser', $logdUser);
		
		$this->set('role', $logdUser->getRole()->getName());
		
		return $this->view();
	}
	
	function rightPanelAction()
	{
		$req = Request::getInstance();
		$controller = $req->getController()->getName();
		$action = $req->getAction();
		
		$logdUser = User::getLoggedIn();
		
		$this->set('logdUser', $logdUser);
		
		$friends = array();
		
		if($controller != 'FriendsController' || $action != 'defaultAction')
		{
			$friends = Friendship::getFriends($logdUser);
		}
		
		$this->set('friends', $friends);
		
		return $this->view();
	}
}
