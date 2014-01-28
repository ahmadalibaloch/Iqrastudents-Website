<?php
class Discussion extends Model
{
	static $table = 'discussions';
	static $cols = 'id, groupId, userId, message, added';
	
	function getGroup()
	{
		return Group::getByPK($this->getGroupId());
	}
	
	function getUser()
	{
		return User::getByPK($this->getUserId());
	}
}