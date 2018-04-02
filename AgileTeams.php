<?php

class AgileTeams
{

	private $employee_nbr;

	public function __construct($queryObject)
	{
			$this->employee_nbr = $queryObject->employee_nbr;
	}


	public function getEmployeeNumber()
	{
		return $this->employee_nbr;
	}
}



?>