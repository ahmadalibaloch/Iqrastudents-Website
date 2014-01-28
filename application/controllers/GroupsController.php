<?php
class GroupsController extends Controller
{
	function defaultAction()
	{
		User::checkPermission('Start Group');
		
		$lgdUser = User::getLoggedIn();
		
		$groups = Group::getAll("userId = {$lgdUser->getId()}");
		
		$this->set('groups', $groups);
		
		return $this->view();
	}
	
	function viewAction()
	{
		$chk = User::hasPermission('Start Group') || User::hasPermission('Join Group');
		
		if($chk == false) return $this->error('You have not enough permissions to view discussion groups');
		
		$groups = Group::getAll();
		
		$this->set('groups', $groups);
		
		return $this->view();
	}
	
	function joinAction($group_id = 0, $member_id = 0)
	{
		if(($group = Group::getByPK($group_id)) && ($member = User::getByPK($member_id)))
		{
			$form = new Form('joingroup');
			$form->add('message', 'bigtext|,255');
			
			if($form->validate())
			{
				if($group->join($member, $form->get('message')))
				{
					$form->clear();
					return 'success';
				}
				
				return 'failure';
			}
			
			$this->set('form', $form);
			return $this->view();
		}
		
		return $this->error('Invalid join request.');
	}
	
	function addAction()
	{
		User::checkPermission('Start Group');
		
		$lgdUser = User::getLoggedIn();
		
		$form = new Form('addgroup');
		$form->add('name', 'text|text|3,100', true);
		$form->add('detail', 'bigtext|3,2000', true);
		
		if($form->validate())
		{
			$group = new Group();
			$group->setUserId($lgdUser->getId());
			$group->setName($form->get('name'));
			$group->setDetail($form->get('detail'));
			$group->setAdded(date('Y-m-d'));
			$group->setStatus('Active');
			
			if($group->save())
			{
				$form->clear();
				redirect(url('groups'));
			}
		}
		
		$this->set('form', $form);
		
		return $this->view();
	}
	
	function editAction($id = 0)
	{
		User::checkPermission('Start Group');
		$lgdUser = User::getLoggedIn();
		
		if($group = Group::getByPK($id))
		{
			$form = new Form('editgroup');
			$status = array('Active'=>'Active','Close'=>'Close');
			
			$form->add('name', 'text|text|3,100', true)->setValue($group->getName());
			$form->add('detail', 'bigtext|3,2000', true)->setValue($group->getDetail());
			$form->add('status', 'radio', true, $status)->setValue($group->getStatus());
			
			if($form->validate())
			{
				$group->setName($form->get('name'));
				$group->setDetail($form->get('detail'));
				$group->setStatus($form->get('status'));
				
				if($group->save())
				{
					$form->clear();
					redirect(url('groups'));
				}
			}
			
			$this->set('form', $form);
			
			return $this->view();
		}
		
		return $this->error('no group found.');
	}
	
	function approveAction($member_id=0, $group_id=0)
	{
		if(($group = Group::getByPK($group_id)) && ($member = User::getByPK($member_id)))
		{
			if($request = GroupMember::getOne("groupId = $group_id and memberId = $member_id"))
			{
				$request->setStatus('Active');
				
				if($request->save()) return 'location.reload';				
			}
		}
		
		return $this->error('invalid request.');
	}
	
	function rejectAction($member_id=0, $group_id=0)
	{
		if(($group = Group::getByPK($group_id)) && ($member = User::getByPK($member_id)))
		{
			if(GroupMember::delete("groupId = $group_id and memberId = $member_id"))
			{
				return 'location.reload';
			}
		}
		
		return $this->error('invalid request.');
	}
	
	function membersAction($id=0)	
	{
		User::checkPermission('Start Group');
		$lgdUser = User::getLoggedIn();
		
		if($group = Group::getByPK($id))
		{
			$members = $group->getMembers();
			unset($members[0]);//owner
			$this->set('members', $members);
			
			return $this->view();
		}
		
		return $this->error('no group found.');
	}
}
