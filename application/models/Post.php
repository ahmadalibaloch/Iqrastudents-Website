<?php
class Post extends Model
{
	static $table = 'posts';
	static $cols = 'id, usrId, category, content, added';
		
	function getUser()
	{
		return User::getByPK($this->getUsrId());
	}
}