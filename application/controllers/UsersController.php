<?php
class UsersController extends Controller
{
	function defaultAction()
	{
		User::checkPermission('View Members');
		
		$logdUser = User::getLoggedIn();
		
		$users = User::getAll("id != {$logdUser->getId()}");
		
		$this->set('users', $users);
		$this->set('editProfilePerm', User::hasPermission('Edit Profile'));
		$this->set('deleteProfilePerm', User::hasPermission('Delete Profile'));

		return $this->view();
	}

	function searchAction()
	{
		$sql = "select name as value from users";
		AutoComplete::init($sql, 'name');

		User::checkPermission('Search Members');
		$logdUser = User::getLoggedIn();
		$users = array();

		$searching = false;
		
		if($q = addslashes(arr($_GET, 'q')))
		{
			$searching = $q;
			$users = User::getAll("name like '$q%' or name like '% $q%'");
		}
		

		$this->set('addFriendsPerm', User::hasPermission('Add Friends'));
		$this->set('searching', $searching);
		$this->set('logdUser', $logdUser);
		$this->set('users', $users);
		return $this->view();
	}

	function profileAction($username='')
	{
		$username = addslashes($username);
		$user = User::getOne("username = '$username'");
		if($user == null) return $this->error('profile not found');
		
		$this->set('user', $user);
		return $this->view();
	}

	function loginAction()
	{
		$form = new Form('login');

		$username = $form->add('username','text', true);
		$password = $form->add('password','password', true);

		if($form->validate())
		{
			$username = addslashes($username->getValue());
			$password = addslashes($password->getValue());
			
			if($user = User::getOne("username = '$username' and password = '$password'"))
			{
				$form->clear();
				$user->login();
				$user->setSeen(date('Y-m-d'));
				$user->save();
				redirect($user->getUrl());
			}
			else $form->error = 'User Name or Password is incorrect.';
		}

		$this->set('form', $form);

		return $this->view();
	}

	function logoutAction()
	{
		User::logout();
		redirect(APP_URL);
	}

	function registerAction()
	{
		$logdUser = User::getLoggedIn();

		$form = $this->getProfileForm('register');

		if($form->validate())
		{
			$username = $form->get('user name');

			$exists = db()->exists('users', 'username', $username);

			if($exists) $form->types['user name']->setError('user name is not available');
			else
			{
				$user = new User();
				$this->fillProfile($form, $user);

				$user->setAdded(date('Y-m-d'));
				$user->setSeen(date('Y-m-d'));
				$user->setStatus('Active');

				if($user->save())
				{
					$form->clear();
					if($logdUser) redirect(url('users'));
					$user->login();
					redirect($user->getUrl());
				}
			}
		}

		$this->set('user', null);
		$this->set('form', $form);

		return $this->view();
	}

	function editAction($username='')
	{
		$username = addslashes($username);
		$user = User::getOne("username = '$username'");		
		if(!$user) return $this->error('profile not found');
		
		User::checkPermission('Edit Profile', $user);
				
		$form = $this->getProfileForm('editProfile', $user->getRole()->getName());
		if($form->validate())
		{
			$username = $form->get('user name');
			$exists = db()->exists('users', 'username', $username, "id != {$user->getId()}");

			if($exists) $form->types['user name']->setError('user name is not available');
			else
			{
				$this->fillProfile($form, $user);
				if($user->save())
				{
					$form->clear();
					redirect($user->getUrl());
				}
			}
		}

		if($form->getPosted() == false)
			$this->fillProfileForm($form, $user);

		$this->set('user', $user);
		$this->set('form', $form);

		return $this->view();
	}

	function deleteAction($id)
	{
		User::checkPermission('Delete Profile');
		$id = intval($id);
		
		if(User::delete("id = $id"))
		{
			Friendship::delete("fromId = $id or toId = $id");
			Post::delete("usrId = $id");
			
			redirect(url('users'));
		}
	}
	
	function getProfileForm($name, $currentRole = '')
	{
		$form = new Form($name);
		$genders = array('Male'=>'Male', 'Female'=>'Female');

		if(($logdUser = User::getLoggedIn()) && $logdUser->inRole('Admin'))
		{
			$roles[4] = 'Teacher';
		}

		if($currentRole && $currentRole == 'Teacher')
		{
			$roles[4] = 'Teacher';
		}
		else
		{
			$roles[3] = 'Student';
			$roles[2] = 'Member';
		}

		$form->add('full name','text|alphabetic|3,30',true);
		$form->add('gender','radio',true,	$genders);
		$form->add('date of birth','text|date',true);
		$form->add('profile image','image|100k|images/users/',true);
		$form->add('email','text|email', true);
		$form->add('category','radio',true,	$roles);
		$form->add('user name','text|alphanumeric|4,15',true);
		$form->add('password','password|4,16',true);
		$form->add('confirm password','match|password',true);

		return $form;
	}

	function fillProfile(Form $form, User $user)
	{
		$user->setName($form->get('full name'));
		$user->setGender($form->get('gender'));
		$user->setDob($form->get('date of birth'));
		$user->setImage($form->get('profile image'));
		$user->setEmail($form->get('email'));
		$user->setUsername($form->get('user name'));
		$user->setPassword($form->get('password'));
		$user->setRolId($form->get('category'));
	}

	function fillProfileForm(Form $form, User $user)
	{
		$types = $form->types;
		$types['full name']->setValue($user->getName());
		$types['gender']->setValue($user->getGender());
		$types['date of birth']->setValue($user->getDob());
		$types['profile image']->setValue($user->getImage());
		$types['email']->setValue($user->getEmail());
		$types['user name']->setValue($user->getUsername());
		$types['password']->setValue($user->getPassword());
		$types['confirm password']->setValue($user->getPassword());
		$types['category']->setValue($user->getRolId());
	}
}