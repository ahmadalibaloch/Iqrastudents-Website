<?php
class Friendship extends Model
{
	static $table = 'friendships';
	static $cols = 'id, fromId, toId, added, status, message';
	
	function approve()
	{
		if($this->getStatus() == 'Pending')
			$this->setStatus('Approved');
		return $this->save();
	}
	
	function reject()
	{
		if($this->getStatus() == 'Pending')
			return self::delete('id = '.$this->getId());
	}
	
	function remove()
	{
		if($this->getStatus() == 'Approved')
			return self::delete('id = '.$this->getId());
	}
	
	static function getFriends($user)
	{
		$sql = "select toId fndId, added
				from friendships where fromId = {$user->getId()} and status = 'Approved'
				union
				select fromId fndId, added
				from friendships where toId = {$user->getId()} and status = 'Approved'
				order by added desc";
				
		$friends = array();
		
		if($rs = db()->query($sql))
		{
			while($row = $rs->fetch_assoc())
			{
				$friends[] = User::getByPK($row['fndId']);
			}
		}
		
		return $friends;
	}
	
	static function getFriendship(User $from, User $to)
	{
		$sql = "select id, fromId, toId, added, status, message
				from friendships where fromId = {$from->getId()} and toId = {$to->getId()} and status = 'Approved'
				union
				select id, fromId, toId, added, status, message
				from friendships where fromId = {$to->getId()} and toId = {$from->getId()} and status = 'Approved'";
		
		if($row = db()->assoc($sql))
			return new Friendship($row);
	}
	
	static function request(User $from, User $to, $message = '')
	{
		$data['fromId'] = $from->getId();
		$data['toId'] = $to->getId();
		$data['added'] = date('Y-m-d h:i:s');
		$data['message'] = $message;		
		$friendship = new Friendship($data);
		return $friendship->save();
	}
	
	static function status(User $from, User $to)
	{
		if($from->getId() == $to->getId()) return 'Self';
		
		if($friendship = Friendship::getOne("fromId = {$from->getId()} and toId = {$to->getId()}"))
		{
			return $friendship->getStatus() == 'Pending' ? 'Awaiting' : 'Approved';			
		}
		elseif($friendship = Friendship::getOne("fromId = {$to->getId()} and toId = {$from->getId()}"))
		{
			return $friendship->getStatus();
		}
	}
	
	static function getRequests(User $user)
	{
		$sql = "select id, fromId, toId, added, 'Awaiting' status, message
				from friendships where fromId = {$user->getId()} and status = 'Pending'
				union
				select id, fromId, toId, added, status, message
				from friendships where toId = {$user->getId()} and status = 'Pending'
				order by added desc";
				
		$requests = array();
		
		if($rs = db()->query($sql))
		{
			while($row = $rs->fetch_assoc())
			{
				$requests[] = new Friendship($row);
			}
		}
		
		return $requests;
	}
	
	static function getRequest(User $from, User $to)
	{
		$sql = "select id, fromId, toId, added, 'Awaiting' status, message
				from friendships where fromId = {$from->getId()} and toId = {$to->getId()} and status = 'Pending'
				union
				select id, fromId, toId, added, status, message
				from friendships where fromId = {$to->getId()} and toId = {$from->getId()} and status = 'Pending'";
		
		if($row = db()->assoc($sql))
			return new Friendship($row);
	}
}