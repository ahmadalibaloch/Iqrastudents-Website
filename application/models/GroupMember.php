<?php
class GroupMember extends Model
{
	static $table = 'groupmembers';
	static $cols = 'id, groupId, memberId, message, added, status';
	
	function getGroup()
	{
		return Group::getByPK($this->getGroupId());
	}
	
	function getMember()
	{
		return User::getByPK($this->getMemberId());
	}
}