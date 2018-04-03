<?php

class SolutionTrain
{
	private $first_name;
	private $last_name;
	private $email_address;
	private $location
	private $st_name;
	
	private $team_id;
	private $role;

	public function __construct($queryObject)
	{
		
		$this->first_name = $queryObject->first_name;
		$this->last_name = $queryObject->last_name;
		$this->email_address = $queryObject->email_address;

		$this->st_name = $queryObject->st_name;

		//$this-> = $queryObject->;

	}

	public function getFirstName()
	{
		return $this->first_name;
	}

	public function getLastName()
	{
		return $this->last_name;
	}

	public function getEmailAddress()
	{
		return $this->email_address;
	}

	public function getRole()
	{
		return $this->role;
	}
	
	public function getCertifications()
	{
		return $this->certifications;
	}
	
	public function getLocationName()
	{
		return $this->location;
	}
	
	public function getSTName()
	{
		return $this->st_name;
	}
	
	public function getCoLocation()
	{
		return $this->co_locate;
	}

	public function getFilledRoles()
	{
		return $this->filled_roles;
	}
	
	public function getTrained()
	{
		return $this->trained;
	}
	
	public function getSize()
	{
		return $this->size;
	}
	
	public function getTeamID()
	{
		return $this->team_id;
	}
	
	public function getProductOwner()
	{
		return $this->product_owner;
	}
	public function getRelease()
	{
		return $this->release;
	}
	
	}

	public static function queryEmployee($id, $type)
	{
		return $sql = "SELECT e.first_name, 
							e.last_name, 
							   e.email_address,
							m.role,
							   tc.course_name,
							   CONCAT(e.city, ', ', e.country) AS location
							FROM employees e
							JOIN membership m ON e.employee_nbr = m.employee_nbr
							JOIN training_enrollment te ON (
							e.first_name = te.first_name AND
							   e.last_name = te.last_name AND
							   e.email_address = te.email
							   )
							JOIN training_calendar tc ON te.training_id = tc.training_id
							WHERE m.team_id IN (
							SELECT team_id 
							   FROM trains_and_teams
							   WHERE parent LIKE
							   '%".$id."' )";
			
			// other parameters added here
			/*if (!empty($type)) {
				$sql .= "AND e.status LIKE '%".$employeeType."%' ";
			}*/
		}
}



?>