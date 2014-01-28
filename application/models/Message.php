<?php
class Message extends Model
{
	static $table = 'messages';
	static $cols = 'id, fromId, toId, message, fromStatus, toStatus, parentId, added';
	
	function getSender()
	{
		return User::getByPK($this->getFromId());
	}
	
	function getReceiver()
	{
		return User::getByPK($this->getToId());
	}
}