<?php
class DiscussionsController extends Controller
{
	function defaultAction($id=0)
	{
		$canjoin = User::hasPermission('Start Group');
		$canstart = User::hasPermission('Join Group');
		
		if($canjoin == false && $canstart == false)
			return $this->error('You are not allowed to post in discussion group');

		$lgdUser = User::getLoggedIn();

		if($group = Group::getByPK($id))
		{
			$discussions = Discussion::getAll("groupId = {$group->getId()}");
			$this->set('group', $group);
			$this->set('canjoin', $canjoin);
			$this->set('lgdUser', $lgdUser);
			$this->set('canstart', $canstart);
			$this->set('discussions', $discussions);

			return $this->view();
		}

		return $this->error('no discussion group found.');
	}

	function addAction($id=0)
	{
		$chk = User::hasPermission('Start Group') || User::hasPermission('Join Group');
		if($chk == false) return $this->error('You are not allowed to post in discussion group');


		$lgdUser = User::getLoggedIn();

		$r['discuss'] = null;
		$r['discussId'] = 0;

		if($group = Group::getByPK($id))
		{
			$form = new Form('adddiscussion');
			$message = $form->add('message', 'bigtext|text|,20000', true);

			if($form->validate())
			{
				$discuss = new Discussion();
				$discuss->setGroupId($group->getId());
				$discuss->setUserId($lgdUser->getId());
				$discuss->setMessage($message->getValue());
				$discuss->setAdded(date('Y-m-d h:i:s'));
				$discuss->save();
				$message->setValue('');

				$this->set('lgdUser', $lgdUser);
				$this->set('discuss', $discuss);

				$r['discuss'] = $this->view('Discussions.discuss');
				$r['discussId'] = $discuss->getId();
			}

			$this->set('form', $form);
			$r['form'] = $this->view('Discussions.form');
		}
		
		return json_encode($r);
	}

	function removeAction($id = 0)
	{
		$chk = User::hasPermission('Start Group') || User::hasPermission('Join Group');
		if($chk == false) return $this->error('You are not allowed to delete this discussion');
		
		$lgdUser = User::getLoggedIn();

		$id = intval($id);

		$r['status'] = 'failure';
		$r['discussId'] = $id;

		if(Discussion::delete("userId = {$lgdUser->getId()} and id = $id"))
		{
			$r['status'] = 'success';
		}

		return json_encode($r);
	}
}
