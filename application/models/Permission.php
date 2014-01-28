<?php
class Permission extends Model
{
	static $table = 'permissions';
	static $cols = 'id, resource, rolId, ownerAccess';
	
	function getRole()
	{
		return Role::getByPK($this->getRolId());
	}
}