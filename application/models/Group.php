<?php
class Group extends Model
{
	static $table = 'groups';
	static $cols = 'id, userId, name, detail, added, status';
	
	function getUser()
	{
		return User::getByPK($this->getUserId());
	}
	
	function getMembers($sql_append = 'true')
	{
		$members[] = $this->getUser();
		
		$sql = "select memberId, status, message, added, groupId from groupmembers where groupId = {$this->getId()} and $sql_append";
		
		if($rs = db()->query($sql))
		{
			while($row = $rs->fetch_assoc())
			{
				if($m = User::getByPK($row['memberId']))
				{
					$m->setReqGroupId($row['groupId']);
					$m->setReqStatus($row['status']);
					$m->setReqMessage($row['message']);
					$m->setReqAdded($row['added']);
					$members[] = $m;
				}
			}
		}
		
		return $members;
	}
	
	function isMember(User $user)
	{
		$is_owner = $this->getUser()->getId() == $user->getId(); //is owner		
		$is_member = db()->exists('groupmembers', 'memberId', $user->getId(), "groupId = {$this->getId()} and status = 'Active'");
		
		return $is_owner || $is_member;
	}
	
	function join(User $user, $message = '')
	{
		$message = addslashes($message);
		
		$sql = "insert into groupmembers set groupId = {$this->getId()}, memberId = {$user->getId()}, message = '$message', added = now(), status = 'Pending'";
		$db = db();
		
		if($db->query($sql)) return $db->insert_id;
		
		return 0;
	}
	
	function getJoinRequest(User $user)
	{
		return GroupMember::getOne("groupId = {$this->getId()} and memberId = {$user->getId()}");
	}
	
	function isPendingMember(User $user)
	{
		return db()->exists('groupmembers', 'memberId', $user->getId(), "groupId = {$this->getId()} and status = 'Pending'");
	}
	
}