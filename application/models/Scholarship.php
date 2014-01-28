<?php
class Scholarship extends Model
{
	static $table = 'scholarships';
	static $cols = 'id, usrId, fatherName, guardianName, guardianOccupation,guardianSalary, guardianPhone, dependentFamilyMembers, klsId, schoolName, lastExam, resultPercentage, added, status';
	function getUser()
	{
		return User::getByPK($this->getUsrId());
	}
	function getKlass()
	{
		return Klass::getByPK($this->getKlsId());
	}
}