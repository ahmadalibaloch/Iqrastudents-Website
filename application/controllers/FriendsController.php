<?php
class FriendsController extends Controller
{
	function defaultAction($username='')
	{
		$username = addslashes($username);
		
		if($username && ($user = User::getOne("username = '$username'")))
		{
			$name = $user->getName()."'s ";
		}
		elseif($user = User::getLoggedIn())		
		{
			$name = 'My ';
		}
		
		if($user == null) return $this->error('profile not found');
		
		$friends = Friendship::getFriends($user);

		$this->set('name', $name);
		$this->set('friends', $friends);
		return $this->view();
	}
	
	function requestsAction()
	{
		User::checkPermission('Add Friends');
		$logdUser = User::getLoggedIn();
		$requests = Friendship::getRequests($logdUser);
		
		$this->set('requests', $requests);
		return $this->view();
	}
	
	function approveAction($id='')
	{
		$user = User::getByPK($id);
		if($user == null) return $this->error('profile not found');
		
		User::checkPermission('Add Friends');
		$logdUser = User::getLoggedIn();
		
		if($request = Friendship::getRequest($logdUser, $user))
		{
			if($request->approve()) redirect(url('friends', 'requests'));
		}
		
		return $this->error('Invalid request');
	}
	
	function rejectAction($id='')
	{
		$user = User::getByPK($id);
		if($user == null) return $this->error('profile not found');
		
		User::checkPermission('Add Friends');
		$logdUser = User::getLoggedIn();
		
		if($request = Friendship::getRequest($logdUser, $user))
		{
			if($request->reject()) redirect(url('friends', 'requests'));
		}
		
		return $this->error('Invalid request');
	}
	
	function removeAction($id='')
	{
		$user = User::getByPK($id);
		if($user == null) return $this->error('profile not found');
		
		User::checkPermission('Add Friends');
		$logdUser = User::getLoggedIn();
		
		if($request = Friendship::getFriendship($logdUser, $user))
		{
			if($request->remove()) redirect(url('friends'));
		}
		
		return $this->error('Invalid request');
	}
	
	function addAction($username = '')
	{
		$username = addslashes($username);
		$user = User::getOne("username = '$username'");
		if($user == null) return $this->error('profile not found');
		
		User::checkPermission('Add Friends');
		
		$logdUser = User::getLoggedIn();
		
		$form = new Form('friendRequest');
		$message = $form->add('message', 'bigtext|text|,255');
		
		if($form->validate())
		{
			if(Friendship::request($logdUser, $user, $message->getValue()))
			{
				$form->clear();
				return 'location.reload';
			}
		}
		
		$this->set('form', $form);
		$this->set('user', $user);
		$this->set('logdUser', $logdUser);
		
		return $this->view();
	}
}