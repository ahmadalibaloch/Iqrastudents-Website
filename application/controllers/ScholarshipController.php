<?php
class ScholarshipController extends Controller
{
	function defaultAction()
	{
		User::checkPermission('Manage Scholarships');
		$logdUsr = User::getLoggedIn();
		$scholarships = Scholarship::getAll();
		$this->set('scholarships',$scholarships);
		return $this->view();
	}
	
	function infoAction($id=0)
	{
		$chk = User::hasPermission('Apply Scholarship');
		$logdUsr = User::getLoggedIn();
		
		$this->set('logdUsr', $logdUsr);
		
		if($id && $chk)
		{
			if($scholarship = Scholarship::getByPK($id))
			{
				$this->set('scholarship',$scholarship);
				return $this->view('Scholarship.detail');
			}
		
		}
	
		return $this->view();
	}
	
	function applyAction()
	{
		User::checkPermission('Apply Scholarship');
		$logdUsr = User::getLoggedIn();
		
		$sholarship = Scholarship::getOne("usrId = {$logdUsr->getId()}");
		
		if($sholarship)
		{
			$this->set('scholarship',$sholarship);
			return $this->view('Scholarship.detail');
		}
		
		$exams['6-month']='Six Month';
		$exams['9-month']='Nine Month';
		$exams['Sendup-Test']='Sendup Test';
		$exams['Annual']='Annual';
		
		$form= new Form('scholarshipForm');
		$form->add('father Name','text|text|3,50',true);
		$form->add('guardian Name','text|text|3,50',false);
		$form->add('guardian Occupation','text|text|3,50',true);
		$form->add('guardian Salary','text|numeric',true);
		$form->add('guardian Phone','text|numeric',true);
		$form->add('dependent Family Members','text|numeric|1,30',true);
		$form->add('class','select',true,Klass::getKeyValue('name'));
		$form->add('school/College Name','text|text|3,100',true);
		$form->add('last Exam','select',true,$exams);
		$form->add('result Percentage','text|numeric|0,100',true);
		
		if($form->validate())
		{
			$scholarship =new Scholarship();
			$scholarship->setUsrId($logdUsr->getId());
			$scholarship->setFatherName($form->get('father Name'));
			$scholarship->setGuardianName($form->get('guardian Name'));
			$scholarship->setGuardianOccupation($form->get('guardian Occupation'));
			$scholarship->setGuardianSalary($form->get('guardian Salary'));
			$scholarship->setGuardianPhone($form->get('guardian Phone'));
			$scholarship->setDependentFamilyMembers($form->get('dependent Family Members'));
			$scholarship->setKlsId($form->get('class'));
			$scholarship->setSchoolName($form->get('school/College Name'));
			$scholarship->setLastExam($form->get('last Exam'));
			$scholarship->setResultPercentage($form->get('result Percentage'));
			$scholarship->setAdded(date('Y-m-d'));
			$scholarship->setStatus('Pending');
			
			if($scholarship->save())
			{
				$form->clear();
				redirect($logdUsr->getUrl());
			}
			
		}
		
		$this->set('logdUsr',$logdUsr);
		$this->set('form',$form);
		return $this->view();
	}
	
	function approveAction($id=0)
	{
		User::checkPermission('Manage Scholarships');
		
		if($scholarship = Scholarship::getByPK($id))
		{
			$scholarship->setStatus('Approved');
			
			if($scholarship->save())
			{
				return 'location.reload';
			}
		}
	}
	
	function rejectAction($id=0)
	{
		User::checkPermission('Manage Scholarships');
		
		if($scholarship = Scholarship::getByPK($id))
		{
			$scholarship->setStatus('Rejected');
			
			if($scholarship->save())
			{
				return 'location.reload';
			}
		}
	}
}
