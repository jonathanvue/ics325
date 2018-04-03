<?php
	//require('db_configuration.php');
	
	/**
	* emp_query - provides HTML template for an employee query.
	* @param: $id - an employee id
	*/
	function emp_query($id) {
		$sql = $result = $row = '';
		$empNbr = $firstName = $lastName = $emailAddress = $city = $country = '';
		$managerName = $agileTeamName = $solutionTrainName = '';
		$role = $status = $courseName = $courseCode = $trainer = $dates = array();
		
		if(empty($id)) {
			$sql = "SELECT e.employee_nbr,
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
				ORDER BY e.employee_nbr
				LIMIT 1
				";
		} else {
			$sql = "SELECT e.employee_nbr,
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
			WHERE e.employee_nbr LIKE '%".$id."';";
		}
		
		// Need to check against SQL injection one day...
		$result = run_sql($sql);
		$rows = $result->num_rows;
		
		// output data of each row
		if ($result->num_rows > 0) {
			while ($row=$result->fetch_assoc()) {
				$empNbr = $row["employee_nbr"];
				$firstName = $row["first_name"];
				$lastName = $row["last_name"];
				$emailAddress = $row["email_address"];
				$city = $row["city"];
				$country = $row["country"];
				$managerName = $row["manager_name"];
				$agileTeamName = $row["at_name"];
				$agileReleaseTrainName = $row["art_name"];
				$solutionTrainName = $row["st_name"];
				$role[] = $row["role"];
				$status[] = $row["status"];
				$courseName[] = $row["course_name"];
				$courseCode[] = $row["course_code"];
				$trainer[] = $row["trainer"];
				$dates[] = $row["dates"];
			}
		}
		
		$result->close();	
		
		// Output HTML string
		echo '
		<div class="container-fluid buffer">
			<!-- Employee -->
			<div class="row">
				<div class="col-md-9">
					<h2><img height="50px" src="./icons/employee.png">Employee: '.$firstName.' '.$lastName.' </h2>
					<table class="table table-condensed table-bordered">
						<tr>
							<thead colspan="2" ><h3>Information</h3></thead>
						</tr>
						<tr>
							<td style="width:200px;">First Name</td>
							<td>'.$firstName.'</td>
						</tr>
						<tr>
							<td>Last Name</td>
							<td>'.$lastName.'</td>
						</tr>
						<tr>
							<td>Email</td>
							<td>'.$emailAddress.'</td>
						</tr>
						<tr>
							<td>City</td>
							<td>'.$city.'</td>
						</tr>
						<tr>
							<td>Country</td>
							<td>'.$country.'</td>
						</tr>
						<tr>
							<td>Manager\'s Name</td>
							<td>'.$managerName.'</td>
						</tr>
					</table>
				</div>
			</div>
			
			<!-- Teams -->
			<div class="row">
				<div class="col-md-9">
					<table class="table table-condensed table-bordered">
						<tr>
							<thead colspan="3" ><h3>Teams</h3></thead>
						</tr>
						<tr>
							<th style="width:200px;">Team</th>
							<th>Team Name</th>
							<th>Role</th>
						</tr>
						
						<tr>
							<td>Agile Team</td>
							<td>'.$agileTeamName.'</td>
							<td>'.displayValues($role).'</td>
						</tr>
						<tr>
							<td>Agile Release Train</td>
							<td>'.$agileReleaseTrainName.'</td>
							<td class="disabled"></td>
						</tr>
						<tr>
							<td>Solution Train</td>
							<td>'.$solutionTrainName.'</td>
							<td></td>
						</tr>
					</table>
				</div>
			</div>
			
			<!-- Training -->
			<div class="row">
				<div class="col-md-9">
					<table class="table table-condensed table-bordered">
						<tr>
							<thead colspan="2"><h3>Training</h3></thead>
						</tr>
						<tr>
							<td style="width:200px;">Status</td>
							<td>'.displayValues($status).'</td>
						</tr>
						<tr>
							<td>Course Name</td>
							<td>'.displayValues($courseName).'</td>
						</tr>
						<tr>
							<td>Course Code</td>
							<td>'.displayValues($courseCode).'</td>
						</tr>
						<tr>
							<td>Trainer</td>
							<td>'.displayValues($trainer).'</td>
						</tr>
						<tr>
							<td>Dates</td>
							<td>'.displayValues($dates).'</td>
						</tr>
					</table>
				</div>
			</div>
		</div>';
	}

	/**
	* at_query - provides HTML template for an agile team query
	* @param: $id - agile team id
	*/
	function at_query($id) {
		$sql = $result = $row = '';
		$agileTeamName = $agileReleaseTrainName = $solutionTrainName = '';
		$firstName = $lastName = $email = $location = '';
		$role = $certifications = array();
		
		$startDatatableHTML = '
				<h3>Team Members</h3>
				<table id="info" class="datatable table table-striped table-bordered">
					<thead>
						<tr>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Email</th>
							<th>Role</th>
							<th>Certification</th>
							<th>Location</th>
						</tr>
					</thead>
				<tbody>';
		$endDatatableHTML = '<tfoot></tfoot>
				</tbody>
			</table>';
		
		// Information query
		if(empty($id)) {
			$sql = "SELECT tt_at.team_id, tt_at.name AS name_at, tt_art.name AS name_art, tt_st.name AS name_st 
				FROM trains_and_teams tt_at
				JOIN trains_and_teams tt_art ON tt_at.parent = tt_art.team_id
				JOIN trains_and_teams tt_st ON tt_art.parent = tt_st.team_id
				ORDER BY tt_at.team_id
				LIMIT 1";
		} else {
			$sql = "SELECT tt_at.team_id, tt_at.name AS name_at, tt_art.name AS name_art, tt_st.name AS name_st 
				FROM trains_and_teams tt_at
				JOIN trains_and_teams tt_art ON tt_at.parent = tt_art.team_id
				JOIN trains_and_teams tt_st ON tt_art.parent = tt_st.team_id
				WHERE tt_at.team_id = '".$id."'";
		}
		
		// output data of each row
		$result = run_sql($sql);
		$row = $result->num_rows;
		
		while ($row = $result->fetch_assoc()){
			$agileTeamName = $row["name_at"];
			$agileReleaseTrainName = $row["name_art"];
			$solutionTrainName = $row["name_st"];
		}
		
		
		// Team members query
		if(empty($id)) {
			$sql = "
				SELECT e.first_name, 
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
				ORDER BY e.employee_nbr
				LIMIT 1;";
		} else {
			$sql = "
				SELECT e.first_name, 
					e.last_name, 
					e.email_address,
					m.role,
					CONCAT(tc.course_name, ' (', tc.course_code, ')') AS certification,
					CONCAT(e.city, ', ', e.country) AS location
				FROM employees e
				JOIN membership m ON e.employee_nbr = m.employee_nbr
				JOIN training_enrollment te ON (
					e.first_name = te.first_name AND
					e.last_name = te.last_name AND
					e.email_address = te.email
					)
				JOIN training_calendar tc ON te.training_id = tc.training_id
				WHERE m.team_id LIKE '%".$id."'";
		}
		
		// output data of each row
		$result = run_sql($sql);
		$row = $result->num_rows;
		
		while ($row = $result->fetch_assoc()){
			$startDatatableHTML .= '<tr>';
			$startDatatableHTML .= '<td>'.$row["first_name"].'</td>';
			$startDatatableHTML .= '<td>'.$row["last_name"].'</td>';
			$startDatatableHTML .= '<td>'.$row["email_address"].'</td>';
			$startDatatableHTML .= '<td>'.$row["role"].'</td>';
			$startDatatableHTML .= '<td>'.$row["certification"].'</td>';
			$startDatatableHTML .= '<td>'.$row["location"].'</td>';
			$startDatatableHTML .= '</tr>';
		}
		
		$startDatatableHTML .= $endDatatableHTML;
		
		$result->close();
		
		// output HTML string
		echo '<div class="container-fluid buffer">
		<div class="row">
			<div class="col-md-9">
				<table class="table table-condesnsed table-bordered">
					<tr>
						<thead colspan="2"><h3>Information</h3></thead>
					</tr>
					<tr>
						<td style="width:200px;"> Team ID</td>
						<td>'.$id.'</td>
					</tr>
					<tr>
						<td>Agile Team Name</td>
						<td>'.$agileTeamName.'</td>
					</tr>
					<tr>
						<td>On Agile Release Train</td>
						<td>'.$agileReleaseTrainName.'</td>
					</tr>
					<tr>
						<td>On Solution Train</td>
						<td>'.$solutionTrainName.'</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">	
			<div class="col-md-9">'.$startDatatableHTML.'
			</div>
		</div>
		<div class="row">
			<div class="col-md-9">
				<table class="table table-condesnsed table-bordered">
					<tr>
						<thead colspan="2"><h3>SAFe Review Comments:</h3></thead>
					</tr>
					<tr>
						<td>Team Size</td>
						<td></td>
					</tr>
					<tr>
						<td>All Roles Filled</td>
						<td></td>
					</tr>
					<tr>
						<td>All are trained</td>
						<td></td>
					</tr>
					<tr>
						<td>Co-located</td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>';
	}
	
	function art_query($id) {
		
	}
	
	function st_query($id) {
		
	}
	
	/**
	* Simple function to display array values with line breaks.
	* @param: &$array - Reference to an array.
	*/
	function displayValues(&$array) {
		$array = array_unique($array);
		$str = '';
		
		foreach($array as $v) {
			$str .= $v."<br>";
		}
		return $str;
	}
?>