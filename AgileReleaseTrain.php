<?php

class AgileReleaseTrain
{
	private $team_id;
	private $team_name;
	private $curr_release_train;

	public function __construct($queryObject)
	{


		//$this-> = $queryObject->;
	}

	public function getTeamID()
	{
		return $team_id;
	}

	public function getTeamName()
	{
		return $team_name;
	}

	public function getCurrentReleaseTrain()
	{
		return $curr_release_train;
	}

	public static function queryEmployee($id, $type)
	{
		return $sql = "SELECT e.employee_nbr,
			e.first_name, 
			e.last_name, 
			e.email_address, 
			e.city, 
			e.country, 
			CONCAT(m.first_name, ' ', m.last_name) AS manager_name,
			mt.role,
			mt.at_name,
			mt.art_name,
			mt.st_name,
			tec.status,
			tec.course_name,
			tec.course_code,
			tec.trainer,
			tec.dates
			FROM employees e
			LEFT OUTER JOIN employees m ON e.managers_nbr = m.employee_nbr
			LEFT OUTER JOIN (
			SELECT m.employee_nbr,
			m.role, 
			tt_at.name AS at_name, 
			tt_art.name AS art_name, 
			tt_st.name AS st_name
			FROM trains_and_teams tt_at
			JOIN trains_and_teams tt_art ON tt_at.parent = tt_art.team_id
			JOIN trains_and_teams tt_st ON tt_art.parent = tt_st.team_id
			LEFT OUTER JOIN membership m ON tt_at.team_id = m.team_id) mt
			ON e.employee_nbr = mt.employee_nbr
			LEFT OUTER JOIN (
			SELECT te.first_name, 
			te.last_name,
			te.email AS email_address,
			tc.status, 
			tc.course_name, 
			tc.course_code, 
			CONCAT(tc.trainer_first_name, ' ', tc.trainer_last_name) AS trainer,
			CONCAT(DATE_FORMAT(tc.start_date, '%m/%d/%Y'), ' - ', DATE_FORMAT(tc.end_date, '%m/%d/%Y')) AS dates
			FROM training_calendar tc
			JOIN training_enrollment te ON tc.training_id = te.training_id) tec
			ON (e.first_name = tec.first_name
			AND e.last_name = tec.last_name
			AND e.email_address = tec.email_address
			)
			WHERE e.employee_nbr LIKE '%".$id."' ";
			
			// other parameters added here
			/*if (!empty($type)) {
				$sql .= "AND e.status LIKE '%".$employeeType."%' ";
			}*/
		}
}



?>