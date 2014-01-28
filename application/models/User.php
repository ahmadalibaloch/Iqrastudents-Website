<?php
class User extends Model
{
	static $table = 'users';
	static $cols = 'id, name, gender, dob, image, email, username, password, rolId, added, seen, status';
	private static $loggedIn = false;
		
	function getRole()
	{
		return Role::getByPK($this->getRolId());
	}
	
	function getAge()
	{		
		return date('Y', time()) - date('Y', strtotime($this->getDob()));
	}
	
	function getUrl($action = 'profile')
	{
		return url('users', $action, array($this->getUsername()));
	}
	
	function getFace($width=40)
	{
		return '<a ajax="container=dialog" href="'.$this->getUrl().'"><img src="'.APP_URL.'images/users/'.$width.'/'.$this->getImage().'" width='.$width.'><br>'.	$this->getName().'</a>';
	}
	
	function inRole($role)
	{
		$r = $this->getRole()->getName();
		
		if($role == 'Admin') 	return $r == 'Admin';
		if($role == 'Teacher') 	return $r == 'Admin' || $r == 'Teacher';		
		if($role == 'Student') 	return $r == 'Admin' || $r == 'Student';
		if($role == 'Member') 	return $r == 'Admin' || $r == 'Teacher' || $r == 'Student' || $r == 'Member';
	}
	
	function isSelf(User $user = null)
	{
		return $user && $this->getId() == $user->getId();
	}
	
	function login()
	{
		$_SESSION['uid'] = $this->getId();
	}
	
	function logout()
	{
		unset($_SESSION['uid']);
	}
	
	static function getLoggedIn()
	{
		if(self::$loggedIn === false)
			self::$loggedIn = User::getByPK(arr($_SESSION, 'uid'));
		
		return self::$loggedIn;
	}
	
	static function hasPermission($resource, User $owner = null)
	{
		$success = false;
		
		if($user = self::getLoggedIn())
		{
			if($perm = Permission::getOne("resource = '$resource'"))
			{
				$success = $user->inRole($perm->getRole()->getName());
				$success = $success == false && $perm->getOwnerAccess() == 'Yes' ? $user->isSelf($owner) : $success;
			}
			else trigger_error('Permission not defined for resource '. $resource, E_USER_ERROR);
		}
		
		return $success;
	}
	
	static function checkPermission($resource, User $owner = null)
	{
		if(self::hasPermission($resource, $owner) == false) redirect(url('users', 'login'));
	}
}