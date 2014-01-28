<?php
class PermissionsController extends Controller
{
	function defaultAction()
	{
		User::checkPermission('View Permissions');

		$perms = array();
		$perms = Permission::getAll();
		$this->set('perms', $perms);
		return $this->view();
	}

	function editAction($permId = 0)
	{
		User::checkPermission('Edit Permission');

		if($perm = Permission::getByPK($permId))
		{
			$form = new Form('editPerms');

			$resource = $form->add('resource', 'literal');
			$role = $form->add('role', 'select', true, Role::getKeyValue('name'));

			$ownerAccess = $form->add('ownerAccess', 'radio', true, array('Yes'=>'Yes','No'=>'No'));
			
			if($form->validate())
			{
				$perm->setRolId($role->getValue());
				$perm->setOwnerAccess($ownerAccess->getValue());
				$perm->save();
				redirect(url('permissions'));
			}

			$resource->setValue($perm->getResource());
			$role->setValue($perm->getRolId());
			$ownerAccess->setValue($perm->getOwnerAccess());

			$this->set('perm', $perm);
			$this->set('form', $form);
			return $this->view();
		}
	}
}
