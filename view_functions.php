<?php
	//require('db_configuration.php');
	
	/**
	* search_query - provides HTML template for a search query.
	* @param: $name - an employee name
	*/
	function search_query($name) {
		// Run search query and find all different types
		$employees = $agileTeams = $agileReleaseTrains = $solutionTrains = array();
		$htmlStart = $htmlEnd = '';
		$sql = "SELECT * 
			FROM search
			WHERE (id LIKE '%".$name."%' OR name LIKE '%".$name."%')
		";
		
		$result = run_sql($sql);
		$rows = $result->num_rows;
		
		// Separate Employees and Teams from query results
		if ($rows > 0) {
			while($row = $result->fetch_assoc()) {
				switch ($row["type"]) {
					case "EMP":
						$employees[] = array("id"=>$row["id"], "type"=>$row["type"], "name"=>$row["name"]);
						break;
					case "AT":
						$agileTeams[] = array("id"=>$row["id"], "type"=>$row["type"], "name"=>$row["name"]);
						break;
					case "ART":
						$agileReleaseTrains[] = array("id"=>$row["id"], "type"=>$row["type"], "name"=>$row["name"]);
						break;
					case "ST":
						$solutionTrains[] = array("id"=>$row["id"], "type"=>$row["type"], "name"=>$row["name"]);
						break;
					default:
						break;
				}
			}
		}
		
		// Build search page
		$htmlStart = '<hr><div class="container-fluid buffer"><hr><h1>Searched for: '.$name.'</h1>';
		$htmlEnd = '</div>';
		$htmlOutput = 	$htmlStart . basic_datatable($employees, 'Employees');
		$htmlOutput .= basic_datatable($agileTeams, 'Agile Teams');
		$htmlOutput .= basic_datatable($agileReleaseTrains, 'Agile Release Trains');
		$htmlOutput .= basic_datatable($solutionTrains, 'Solution Trains');
		$htmlOutput .= $htmlEnd;
		
		echo $htmlOutput;
	}
	
	/**
	* basic_datatable - builds a basic table with rows and columns
	* @param: $data - an array of associative array values
	* 				$title - name of table
	* @return: html string
	*/ 
	function basic_datatable ($data, $title) {
		if (!$data) {
			return '';
		}
		
		$keys = array_keys($data[0]);
		$cols = count($keys);
		$titleID = str_replace(" ", "_", strtolower($title));
		
		$startTableHeader = '<h2>'.$title.'</h2><div class="row"><div class="col-md-8"><colgroup></colgroup>
			<table id="'.$titleID.'" class="datatable table table-striped table-bordered search-tables" >
			<thead><tr>';
		$endTableHeader = '</tr></thead>';
		$tableBody = '<tbody>';
		$tableFooter = '</tbody></table></div></div>';
		
		// Add column names to table
		foreach($keys as $key) {
			$startTableHeader .= '<th>'.ucfirst($key).'</th>';
		}
		
		// Add row data to table
		foreach($data as $row) {
			$tableBody .= '<tr>';
			$link = 'view.php?type='.$row["type"].'&id='.$row["id"];
			
			foreach($row as $key=>$value) {
				if ($key !== "id") {
					$tableBody .= '<td>'.$value.'</td>';
				} else {
					$tableBody .= '<td><a href="'.$link.'">'.$value.'</a></td>';
				}
				
			}
			$tableBody .= '</a></tr>';
		}
		
		return $startTableHeader . $endTableHeader . $tableBody . $tableFooter;
	}
	
	/**
	* add_datatable_script - NO USE
	*
	*/
	function add_datatable_script($data) {
		$script = '<script type="text/javascript">
			$(document).ready(function() {';
			
		foreach($data as $id) {
			$script .= "$('#".$id."').DataTable();
			";
		}
		
		$script .= "});";
		
		return $script;
	}
	
	/**
	* emp_query - provides HTML template for an employee query.
	* @param: $id - an employee id
	*/
	function emp_query($id) {
		$sql = $result = $row = '';
		$empNbr = $mgrNbr = $firstName = $lastName = $emailAddress = $city = $country = '';
		$managerName = $f = $l = $employeeStatus = '';
		$role = $status = $agileTeamID = $agileReleaseTrainID =$solutionTrainID = $agileTeamName = $agileReleaseTrainName = $solutionTrainName = $courseName = $courseCode = $trainer = $dates = array();
		
		$where = "WHERE e.employee_nbr LIKE '%".$id."';";
		$f = $l = '';
		
		// Drop down div
		$dropdown = '<div class="dropdown-info dropdown-menu">
				<ul>
					<li><a href="#">Some stuff here</a></li>
					<li><a href="#">Some stuff here</a></li>
					<li><a href="#">Some stuff here</a></li>
				</ul>
		</div>';
		
		//If id is first and last name instead of an integer employee_id
		if (strpos($id, ' ')) {
			$id = explode(' ', $id);
			$f = $id[0];
			$l = $id[1];
			$where = "WHERE e.first_name = '".$f."' AND e.last_name = '".$l."'";
		}
		
		$sql = "SELECT e.employee_nbr,
				e.first_name, 
				e.last_name, 
				e.email_address, 
				e.city, 
				e.country,
				e.status AS employee_status,
				m.employee_nbr AS manager_nbr,
				CONCAT(m.first_name, ' ', m.last_name) AS manager_name,
				mt.role,
				mt.at_id,
				mt.at_name,
				mt.art_id,
				mt.art_name,
				mt.st_id,
				mt.st_name,
				tec.status,
				tec.course_name,
				tec.course_code,
				tec.trainer,
				tec.dates
			FROM employees e
			LEFT OUTER JOIN employees m ON e.managers_nbr = m.employee_nbr
			LEFT OUTER JOIN (
				SELECT employee_nbr,
					role,
					tt_at.team_id AS at_id,
					tt_at.name AS at_name, 
					tt_art.team_id AS art_id,
					tt_art.name AS art_name, 
					tt_st.team_id AS st_id,
					tt_st.name AS st_name
				FROM trains_and_teams tt_at
				JOIN trains_and_teams tt_art ON tt_at.parent = tt_art.team_id
				JOIN trains_and_teams tt_st ON tt_art.parent = tt_st.team_id
				JOIN membership m ON (m.team_id = tt_at.team_id
					OR m.team_id = tt_art.team_id
					OR m.team_id = tt_st.team_id)
				) mt ON e.employee_nbr = mt.employee_nbr
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
					) ".$where;
		
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
				$employeeStatus = $row["employee_status"];
				$mgrNbr = $row["manager_nbr"];
				$managerName = $row["manager_name"];
				$agileTeamID[] = $row["at_id"];
				$agileTeamName[] = $row["at_name"];
				$agileReleaseTrainID[] = $row["art_id"];
				$agileReleaseTrainName[] = $row["art_name"];
				$solutionTrainID[] = $row["st_id"];
				$solutionTrainName[] = $row["st_name"];
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
		$htmlOutput = '<div class="container-fluid buffer">
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
							<td><a href="view.php?type=EMP&id='.$mgrNbr.'">'.$managerName.'</a></td>
						</tr>
					</table>
				</div>
			</div>
			';
			
		// Check if employee is a trainer
		if ($employeeStatus === 'Trainer') {
			// Init html
			$htmlOutput .= '<div class="row">
				<div class="col-md-9">
					<table class="table table-condensed table-bordered">
						<tr>
							<thead colspan="3"><h3>Training History</h3></thead>
						</tr>
						<tr>
							<th style="width:300px;">Course Code</th>
							<th>Course Name</th>
							<th>Location</th>
							<th>Dates</th>
							<th>Count</th>
						</tr>';
			
			// Query database for trainer information
			$sql = "SELECT course_name,
					course_code,
					location,
					CONCAT(start_date, ' to ', end_date) AS dates,
					COUNT(te.training_id) AS count
				FROM training_calendar tc
				JOIN training_enrollment te ON tc.training_id = te.training_id
				WHERE trainer_first_name = '".$f."'
				AND trainer_last_name = '".$l."'
				GROUP BY tc.training_id;";
			
			$result = run_sql($sql);
			
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$htmlOutput .= '<tr>
						<td>'.$row["course_name"].'</td>
						<td>'.$row["course_code"].'</td>
						<td>'.$row["location"].'</td>
						<td>'.$row["dates"].'</td>
						<td class="dropdown"><a href="search.php?name='.$f.'">'.$row["count"].'</a>'.$dropdown.'</td>
						</tr>';
				}
			}
			
			// Close tags in html
			$htmlOutput .= '</table></div></div>';
		} else {
			$htmlOutput .= '<!-- Teams -->
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
								'.employeeTable($agileTeamID, $agileTeamName, "AT").'
								<td>'.displayValues($role).'</td>
							</tr>
							<tr>
								<td>Agile Release Train</td>
								'.employeeTable($agileReleaseTrainID, $agileReleaseTrainName, "ART").'
								<td class="disabled"></td>
							</tr>
							<tr>
								<td>Solution Train</td>
								'.employeeTable($solutionTrainID, $solutionTrainName, "ST").'
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
		
		echo $htmlOutput;
}	
	
	/**
	* at_query - provides HTML template for an agile team query
	* @param: $id - agile team id
	*/
	function at_query($id) {
		$sql = $result = $row = '';
		$teamID = $agileTeamName = $agileReleaseTrainName = $solutionTrainName = '';
		$firstName = $lastName = $email = $location = $locationUnique = $rolesFilled = $certsFilled = '';
		$role = $certifications = $multipleLocations = $allCerts = $allRoles = array();
		$numTeamMembers = 0;
		
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
			$sql = "SELECT tt_at.team_id, 
					tt_at.name AS name_at, 
					tt_art.team_id AS art_id,
					tt_art.name AS name_art,
					tt_st.team_id AS st_id,
					tt_st.name AS name_st 
				FROM trains_and_teams tt_at
				JOIN trains_and_teams tt_art ON tt_at.parent = tt_art.team_id
				JOIN trains_and_teams tt_st ON tt_art.parent = tt_st.team_id
				LIMIT 1";
		} else {
			$sql = "SELECT tt_at.team_id, 
					tt_at.name AS name_at, 
					tt_art.team_id AS art_id,
					tt_art.name AS name_art,
					tt_st.team_id AS st_id,
					tt_st.name AS name_st 
				FROM trains_and_teams tt_at
				JOIN trains_and_teams tt_art ON tt_at.parent = tt_art.team_id
				JOIN trains_and_teams tt_st ON tt_art.parent = tt_st.team_id
				WHERE tt_at.team_id = '".$id."'";
		}
		
		// output data of each row
		$result = run_sql($sql);
		$row = $result->num_rows;
		
		while ($row = $result->fetch_assoc()){
			$agileTeamID = $row["team_id"];
			$agileTeamName = $row["name_at"];
			$agileReleaseTrainID = $row["art_id"];
			$agileReleaseTrainName = $row["name_art"];
			$solutionTrainID = $row["st_id"];
			$solutionTrainName = $row["name_st"];
		}
		
		// Team members query
		if(empty($id)) {
			$sql = "
				SELECT e.employee_nbr,
					m.team_id,
					m.first_name, 
					m.last_name, 
					e.email_address, 
					m.role, 
					CONCAT(t.course_name, ' (', t.course_code, ')') AS certification, 
					CONCAT(e.city, ', ', e.country) AS location
				FROM membership m
				JOIN employees e ON e.employee_nbr = m.employee_nbr
				LEFT OUTER JOIN (
					SELECT te.*, tc.course_name, tc.course_code
					FROM training_calendar tc
					JOIN training_enrollment te ON tc.training_id = te.training_id
					WHERE status = 'Done'
					) t ON (
						m.first_name = t.first_name AND
						m.last_name = t.last_name
						)
				ORDER BY e.employee_nbr
				LIMIT 1;";
		} else {
			$sql = "
				SELECT e.employee_nbr,
					m.team_id, 
					m.first_name, 
					m.last_name, 
					e.email_address, 
					m.role, 
					CONCAT(t.course_name, ' (', t.course_code, ')') AS certification, 
					CONCAT(e.city, ', ', e.country) AS location
				FROM membership m
				JOIN employees e ON e.employee_nbr = m.employee_nbr
				LEFT OUTER JOIN (
					SELECT te.*, tc.course_name, tc.course_code
					FROM training_calendar tc
					JOIN training_enrollment te ON tc.training_id = te.training_id
					WHERE status = 'Done'
					) t ON (
						m.first_name = t.first_name AND
						m.last_name = t.last_name
						)
				WHERE m.team_id LIKE '%".$id."'";
		}
		
		// output data of each row
		$result = run_sql($sql);
		$row = $result->num_rows;
		
		while ($row = $result->fetch_assoc()){

			if($numTeamMembers %2 === 0)
			{
				//Do nothing if it is the duplicated row that was displaying.
			}
			else
			{
				$multipleLocations[] =$row["location"];
				$teamID = $row["team_id"];
				$allRoles[] = $row["role"];
				$allCerts[] = $row["certification"];
			
			
				$startDatatableHTML .= '<tr>';
				$startDatatableHTML .= '<td><a href="view.php?type=EMP&id='.$row["employee_nbr"].'">'.$row["first_name"].'</a></td>';
				$startDatatableHTML .= '<td><a href="view.php?type=EMP&id='.$row["employee_nbr"].'">'.$row["last_name"].'</a></td>';
				$startDatatableHTML .= '<td>'.$row["email_address"].'</td>';
				$startDatatableHTML .= '<td><a href="view.php?type=EMP&id='.$row["employee_nbr"].'">'.$row["role"].'</a></td>';
				$startDatatableHTML .= '<td>'.$row["certification"].'</td>';
				$startDatatableHTML .= '<td>'.$row["location"].'</td>';
				$startDatatableHTML .= '</tr>';
			}

			$numTeamMembers++;
		}
		$startDatatableHTML .= $endDatatableHTML;
		$result->close();
		
		// check for unique locations
		if (count(array_unique($multipleLocations)) > 1) {
			$locationUnique = 'No';
		} else {
			$locationUnique = 'Yes';
		}
		
		// check if all roles are filled
		if (count(array_filter($allRoles)) < $numTeamMembers - 1) {
			$rolesFilled = 'No';
		} else {
			$rolesFilled = 'Yes';
		}
		
		// check if all certs are fileld
		if (count(array_filter($allCerts)) < $numTeamMembers - 1) {
			$certsFilled = 'No';
		} else {
			$certsFilled = 'Yes';
		}
		
		
		// output HTML string
		echo '<div class="container-fluid buffer">
		<div class="row">
			<div class="col-md-9">
				<h2><img height="50px" src="./icons/agile_team.png">Agile Team: '.$agileTeamName.' </h2>
				<table class="table table-condensed table-bordered">
					<tr>
						<thead colspan="2"><h3>Information</h3></thead>
					</tr>
					<tr>
						<td style="width:200px;"> Team ID</td>
						<td>'.$teamID.'</td>
					</tr>
					<tr>
						<td>Agile Team Name</td>
						<td><a href="view.php?type=AT&id='.$agileTeamID.'">'.$agileTeamName.'</a></td>
					</tr>
					<tr>
						<td>On Agile Release Train</td>
						<td><a href="view.php?type=ART&id='.$agileReleaseTrainID.'">'.$agileReleaseTrainName.'</a></td>
					</tr>
					<tr>
						<td>On Solution Train</td>
						<td><a href="view.php?type=ST&id='.$solutionTrainID.'">'.$solutionTrainName.'</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">	
			<div class="col-md-9">'.$startDatatableHTML.'
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<table class="table table-condensed table-bordered">
					<tr>
						<thead colspan="2"><h3>SAFe Review Comments:</h3></thead>
					</tr>
					<tr>
						<td style="width:200px;">Team Size</td>
						<td>'.$numTeamMembers.'</td>
					</tr>
					<tr>
						<td>All Roles Filled</td>
						<td>'.$rolesFilled.'</td>
					</tr>
					<tr>
						<td>All are trained</td>
						<td>'.$certsFilled.'</td>
					</tr>
					<tr>
						<td>Co-located</td>
						<td>'.$locationUnique.'</td>
					</tr>
				</table>
			</div>
		</div>';
		//<pre>'.print_r($allRoles, true).'</pre>
		//<pre>'.print_r(array_filter($allCerts), true).'</pre>';
	}
	
	/**
	* art_query - provides HTML template for an agile release train query
	* @param: $id - agile release train id
	*/
	function art_query($id) {
		$sql = $result = $row = '';
		$teamID = $agileReleaseTrainName = $solutionTrainName = $scrumMaster = $productOwner = '';
		$firstName = $lastName = $email = $location = $locationUnique = $rolesFilled = $certsFilled = '';
		$role = $certifications = $multipleLocations = $allCerts = $allRoles = array();
		$numTeamMembers = 0;
		
		// Datatable setup
		$startDatatableHTML_teamMembers = '
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
			
		$startDatatableHTML_participatingAgileTeams = '
				<h3>Participating Agile Teams</h3>
				<table id="info2" class="datatable table table-striped table-bordered">
					<thead>
						<tr>
							<th>Team ID</th>
							<th>Team Name</th>
							<th>Scrum Master</th>
							<th>Product Manager</th>
						</tr>
					</thead>
				<tbody>';
				
		$endDatatableHTML = '<tfoot></tfoot>
				</tbody>
			</table>';
			
		// Information query
		if(empty($id)) {
			$sql = "SELECT tt_art.team_id AS art_id,
					tt_art.name AS name_art,
					tt_st.team_id AS st_id,
					tt_st.name AS name_st 
				FROM trains_and_teams tt_art
				JOIN trains_and_teams tt_st ON tt_art.parent = tt_st.team_id
				LIMIT 1";
		} else {
			$sql = "SELECT tt_art.team_id AS art_id,
					tt_art.name AS name_art,
					tt_st.team_id AS st_id,
					tt_st.name AS name_st 
				FROM trains_and_teams tt_art
				JOIN trains_and_teams tt_st ON tt_art.parent = tt_st.team_id
				WHERE tt_art.team_id = '".$id."'";
		}
		
		// output data of each row
		$result = run_sql($sql);
		$row = $result->num_rows;
		
		while ($row = $result->fetch_assoc()){
			$agileReleaseTrainID = $row["art_id"];
			$agileReleaseTrainName = $row["name_art"];
			$solutionTrainID =$row["st_id"];
			$solutionTrainName = $row["name_st"];
		}
		
		// Team members query
		if(empty($id)) {
			$sql = "
				SELECT e.employee_nbr,
					m.team_id,
					m.first_name, 
					m.last_name, 
					e.email_address, 
					m.role, 
					CONCAT(t.course_name, ' (', t.course_code, ')') AS certification, 
					CONCAT(e.city, ', ', e.country) AS location
				FROM membership m
				JOIN employees e ON e.employee_nbr = m.employee_nbr
				LEFT OUTER JOIN (
					SELECT te.*, tc.course_name, tc.course_code
					FROM training_calendar tc
					JOIN training_enrollment te ON tc.training_id = te.training_id
					WHERE status = 'Done'
					) t ON (
						m.first_name = t.first_name AND
						m.last_name = t.last_name
						)
				ORDER BY e.employee_nbr
				LIMIT 1;";
		} else {
			$sql = "
				SELECT e.employee_nbr,
					m.team_id, 
					m.first_name, 
					m.last_name, 
					e.email_address, 
					m.role, 
					CONCAT(t.course_name, ' (', t.course_code, ')') AS certification, 
					CONCAT(e.city, ', ', e.country) AS location
				FROM membership m
				JOIN employees e ON e.employee_nbr = m.employee_nbr
				LEFT OUTER JOIN (
					SELECT te.*, tc.course_name, tc.course_code
					FROM training_calendar tc
					JOIN training_enrollment te ON tc.training_id = te.training_id
					WHERE status = 'Done'
					) t ON (
						m.first_name = t.first_name AND
						m.last_name = t.last_name
						)
				WHERE m.team_id LIKE '%".$id."'";
		}
		
		// output data of each row
		$result = run_sql($sql);
		$row = $result->num_rows;
		
		while ($row = $result->fetch_assoc()){
			if($numTeamMembers %2 === 0)
			{
				//Do nothing if it is the duplicated row that was displaying.
			}
			else
			{
			$multipleLocations[] =$row["location"];
			$teamID = $row["team_id"];
			$allRoles[] = $row["role"];
			$allCerts[] = $row["certification"];
			
			$startDatatableHTML_teamMembers .= '<tr>';
			$startDatatableHTML_teamMembers .= '<td><a href="view.php?type=EMP&id='.$row["employee_nbr"].'">'.$row["first_name"].'</a></td>';
			$startDatatableHTML_teamMembers .= '<td><a href="view.php?type=EMP&id='.$row["employee_nbr"].'">'.$row["last_name"].'</a></td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["email_address"].'</td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["role"].'</td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["certification"].'</td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["location"].'</td>';
			$startDatatableHTML_teamMembers .= '</tr>';
			}

			$numTeamMembers++;
		}
		$startDatatableHTML_teamMembers .= $endDatatableHTML;
		
		// Participating Agile Release Train query
		if(empty($id)){
			$sql = "SELECT m.team_id, m.team_name, s.scrum_master, p.product_manager
				FROM membership m
				LEFT OUTER JOIN (
					SELECT team_id, CONCAT(first_name, ' ', last_name) AS scrum_master
					FROM membership
					WHERE role LIKE '%scrum_master%'
					) s ON m.team_id = s.team_id
				LEFT OUTER JOIN (
					SELECT team_id, CONCAT(first_name, ' ', last_name) AS product_manager 
					FROM membership
					WHERE role LIKE '%Product Manager%'
					) p ON m.team_id = p.team_id
				GROUP BY m.team_id, m.team_name, s.scrum_master, p.product_manager
				ORDER BY m.team_id
				LIMIT 1";
		} else {
			$sql = "SELECT m.team_id, m.team_name, s.scrum_master, p.product_manager
				FROM membership m
				LEFT OUTER JOIN (
					SELECT team_id, CONCAT(first_name, ' ', last_name) AS scrum_master
					FROM membership
					WHERE role LIKE '%scrum_master%'
					) s ON m.team_id = s.team_id
				LEFT OUTER JOIN (
					SELECT team_id, CONCAT(first_name, ' ', last_name) AS product_manager 
					FROM membership
					WHERE role LIKE '%Product Manager%'
					) p ON m.team_id = p.team_id
				WHERE m.team_id IN (
					SELECT team_id 
					FROM trains_and_teams
					WHERE parent LIKE '%".$id."')
				GROUP BY m.team_id, m.team_name, s.scrum_master, p.product_manager";
		}
		
		$result = run_sql($sql);
		$row = $result->num_rows;
		
		while ($row = $result->fetch_assoc()){
			$startDatatableHTML_participatingAgileTeams .= '<tr>';
			$startDatatableHTML_participatingAgileTeams .= '<td>'.$row["team_id"].'</td>';
			$startDatatableHTML_participatingAgileTeams .= '<td>'.$row["team_name"].'</td>';
			$startDatatableHTML_participatingAgileTeams .= '<td>'.$row["scrum_master"].'</td>';
			$startDatatableHTML_participatingAgileTeams .= '<td>'.$row["product_manager"].'</td>';
			$startDatatableHTML_participatingAgileTeams .= '</tr>';
		}
		$startDatatableHTML_participatingAgileTeams .= $endDatatableHTML;
		
		$result->close();
		
		// check for unique locations
		if (count(array_unique($multipleLocations)) > 1) {
			$locationUnique = 'No';
		} else {
			$locationUnique = 'Yes';
		}
		
		// check if all roles are filled
		if (count(array_filter($allRoles)) < $numTeamMembers - 1) {
			$rolesFilled = 'No';
		} else {
			$rolesFilled = 'Yes';
		}
		
		// check if all certs are fileld
		if (count(array_filter($allCerts)) < $numTeamMembers - 1) {
			$certsFilled = 'No';
		} else {
			$certsFilled = 'Yes';
		}
		
		
		// output HTML string
		echo '<div class="container-fluid buffer">
		<div class="row">
			<div class="col-md-9">
				<h2><img height="50px" src="./icons/agile_release_train.png">Agile Release Train: '.$agileReleaseTrainName.' </h2>
				<table class="table table-condensed table-bordered">
					<tr>
						<thead colspan="2"><h3>Information</h3></thead>
					</tr>
					<tr>
						<td style="width:200px;"> Team ID</td>
						<td>'.$agileReleaseTrainID.'</td>
					</tr>
					<tr>
						<td>On Agile Release Train</td>
						<td>'.$agileReleaseTrainName.'</td>
					</tr>
					<tr>
						<td>On Solution Train</td>
						<td><a href="view.php?type=ST&id='.$solutionTrainID.'">'.$solutionTrainName.'</a></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">	
			<div class="col-md-9">'.$startDatatableHTML_teamMembers.'
			</div>
		</div>
		<div class="row">	
			<div class="col-md-9">'.$startDatatableHTML_participatingAgileTeams.'
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<table class="table table-condensed table-bordered">
					<tr>
						<thead colspan="2"><h3>SAFe Review Comments:</h3></thead>
					</tr>
					<tr>
						<td style="width: 200px;">Team Size</td>
						<td>'.$numTeamMembers.'</td>
					</tr>
					<tr>
						<td>All Roles Filled</td>
						<td>'.$rolesFilled.'</td>
					</tr>
					<tr>
						<td>All are trained</td>
						<td>'.$certsFilled.'</td>
					</tr>
					<tr>
						<td>Co-located</td>
						<td>'.$locationUnique.'</td>
					</tr>
				</table>
			</div>
		</div>';
	}
	
	/**
	* st_query - provides HTML template for a solution train query
	* @param: $id - solution train id
	*/
	function st_query($id) {
		$sql = $result = $row = '';
		$teamID = $solutionTrainName = $releaseTrainEngineer = $productOwner = '';
		$firstName = $lastName = $email = $location = $locationUnique = $rolesFilled = $certsFilled = '';
		$role = $certifications = $multipleLocations = $allCerts = $allRoles = array();
		$numTeamMembers = 0;
		
		// Datatable setup
		$startDatatableHTML_teamMembers = '
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
			
		$startDatatableHTML_participatingReleaseTrains = '
				<h3>Participating Agile Release Trains</h3>
				<table id="info2" class="datatable table table-striped table-bordered">
					<thead>
						<tr>
							<th>Team ID</th>
							<th>Team Name</th>
							<th>Release Train Engineer (RTE)</th>
							<th>Product Manager</th>
						</tr>
					</thead>
				<tbody>';
				
		$endDatatableHTML = '<tfoot></tfoot>
				</tbody>
			</table>';
			
		// Information query
		if(empty($id)) {
			$sql = "SELECT tt_st.team_id, tt_st.name AS name_st 
				FROM trains_and_teams st_at
				ORDER BY tt_st.team_id
				LIMIT 1";
		} else {
			$sql = "SELECT tt_st.team_id, tt_st.name AS name_st 
				FROM trains_and_teams tt_st
				WHERE tt_st.team_id = '".$id."'";
		}
		
		// output data of each row
		$result = run_sql($sql);
		$row = $result->num_rows;
		
		while ($row = $result->fetch_assoc()){
			$solutionTrainName = $row["name_st"];
		}
		
		// Team members query
		if(empty($id)) {
			$sql = "
				SELECT e.employee_nbr,
					m.team_id,
					m.first_name, 
					m.last_name, 
					e.email_address, 
					m.role, 
					CONCAT(t.course_name, ' (', t.course_code, ')') AS certification, 
					CONCAT(e.city, ', ', e.country) AS location
				FROM membership m
				JOIN employees e ON e.employee_nbr = m.employee_nbr
				LEFT OUTER JOIN (
					SELECT te.*, tc.course_name, tc.course_code
					FROM training_calendar tc
					JOIN training_enrollment te ON tc.training_id = te.training_id
					WHERE status = 'Done'
					) t ON (
						m.first_name = t.first_name AND
						m.last_name = t.last_name
						)
				ORDER BY e.employee_nbr
				LIMIT 1;";
		} else {
			$sql = "
				SELECT e.employee_nbr,
					m.team_id, 
					m.first_name, 
					m.last_name, 
					e.email_address, 
					m.role, 
					CONCAT(t.course_name, ' (', t.course_code, ')') AS certification, 
					CONCAT(e.city, ', ', e.country) AS location
				FROM membership m
				JOIN employees e ON e.employee_nbr = m.employee_nbr
				LEFT OUTER JOIN (
					SELECT te.*, tc.course_name, tc.course_code
					FROM training_calendar tc
					JOIN training_enrollment te ON tc.training_id = te.training_id
					WHERE status = 'Done'
					) t ON (
						m.first_name = t.first_name AND
						m.last_name = t.last_name
						)
				WHERE m.team_id LIKE '%".$id."'";
		}
		
		// output data of each row
		$result = run_sql($sql);
		$row = $result->num_rows;
		
		while ($row = $result->fetch_assoc()){

			if($numTeamMembers %2 === 0)
			{
				//Do nothing if it is the duplicated row that was displaying.
			}
			else
			{
				$multipleLocations[] =$row["location"];
				$teamID = $row["team_id"];
				$allRoles[] = $row["role"];
				$allCerts[] = $row["certification"];
			
			$startDatatableHTML_teamMembers .= '<tr>';
			$startDatatableHTML_teamMembers .= '<td><a href="view.php?type=EMP&id='.$row["employee_nbr"].'">'.$row["first_name"].'</a></td>';
			$startDatatableHTML_teamMembers .= '<td><a href="view.php?type=EMP&id='.$row["employee_nbr"].'">'.$row["last_name"].'</a></td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["email_address"].'</td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["role"].'</td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["certification"].'</td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["location"].'</td>';
			$startDatatableHTML_teamMembers .= '</tr>';
			}
			$numTeamMembers++;
		}
		$startDatatableHTML_teamMembers .= $endDatatableHTML;
		
		// Participating Agile Release Train query
		if(empty($id)){
			$sql = "SELECT m.team_id, m.team_name, r.release_train_engineer, p.product_manager
				FROM membership m
				LEFT OUTER JOIN (
					SELECT team_id, CONCAT(first_name, ' ', last_name) AS release_train_engineer
					FROM membership
					WHERE role LIKE '%Release Train Engineer%'
					) r ON m.team_id = r.team_id
				LEFT OUTER JOIN (
					SELECT team_id, CONCAT(first_name, ' ', last_name) AS product_manager 
					FROM membership
					WHERE role LIKE '%Product Manager%'
					) p ON m.team_id = p.team_id
				WHERE m.team_id IN (
					SELECT team_id 
					FROM trains_and_teams
					WHERE parent LIKE '%st-100%')
				GROUP BY m.team_id, m.team_name, r.release_train_engineer, p.product_manager
				ORDER BY m.team_id
				LIMIT 1";
		} else {
			$sql = "SELECT m.team_id, m.team_name, r.release_train_engineer, p.product_manager
				FROM membership m
				LEFT OUTER JOIN (
					SELECT team_id, CONCAT(first_name, ' ', last_name) AS release_train_engineer
					FROM membership
					WHERE role LIKE '%Release Train Engineer%'
					) r ON m.team_id = r.team_id
				LEFT OUTER JOIN (
					SELECT team_id, CONCAT(first_name, ' ', last_name) AS product_manager 
					FROM membership
					WHERE role LIKE '%Product Manager%'
					) p ON m.team_id = p.team_id
				WHERE m.team_id IN (
					SELECT team_id 
					FROM trains_and_teams
					WHERE parent LIKE '%".$id."%')
				GROUP BY m.team_id, m.team_name, r.release_train_engineer, p.product_manager";
		}
		
		$result = run_sql($sql);
		$row = $result->num_rows;
		$teams = array();
		$test = '';
		
		// Go through query results
		while ($row = $result->fetch_assoc()){
			$teamFound = array_search($row["team_id"], $teams);
			// Check if team_id does not exist
			if ($teamFound === false){
				$teams[$row["team_id"]] = array("team_name" => $row["team_name"], "release_train_engineer" => array($row["release_train_engineer"]), "product_manager" => array($row["product_manager"]));
			} else {
				$rteFound = @array_search($row["release_train_engineer"], $teams[$row["team_id"]]["release_train_engineer"]);
				$pmFound = @array_search($row["product_manager"], $teams[$row["team_id"]]["product_manager"]);
				
				if($rteFound !== false) {
					$teams[$row["team_id"]]["release_train_engineer"][] = $row["release_train_engineer"];
				}
				
				if($pmFound !== false) {
					$teams[$row["team_id"]]["product_manager"][] = $row["product_manager"];
				}	
			}
		}
	
		
		$outputStuff = print_r($teams, true);
		
		foreach($teams as $team_id => $teamInfo) {
			$startDatatableHTML_participatingReleaseTrains .= '<tr>';
			$startDatatableHTML_participatingReleaseTrains .= '<td><a href="view.php?type=ART&id='.$team_id.'">'.$team_id.'</a></td>';
			$startDatatableHTML_participatingReleaseTrains .= '<td>'.$teamInfo["team_name"].'</td>';
			$startDatatableHTML_participatingReleaseTrains .= '<td>';
			
			foreach($teamInfo["release_train_engineer"] AS $rte) {
				$startDatatableHTML_participatingReleaseTrains .= '<a href="view.php?type=EMP&id='.urlencode($rte).'">'.$rte.'</a><br>';
			}
			$startDatatableHTML_participatingReleaseTrains .= '</td><td>';
			
			foreach($teamInfo["product_manager"] AS $pm) {
				$startDatatableHTML_participatingReleaseTrains .= '<a href="view.php?type=EMP&id='.urlencode($pm).'">'.$pm.'</a><br>';	
			} 
			$startDatatableHTML_participatingReleaseTrains .= '</td></tr>';
		}
		
		/*
		while ($row = $result->fetch_assoc()){
			$startDatatableHTML_participatingReleaseTrains .= '<tr>';
			$startDatatableHTML_participatingReleaseTrains .= '<td><a href="view.php?type=ART&id='.$row["team_id"].'">'.$row["team_id"].'</a></td>';
			$startDatatableHTML_participatingReleaseTrains .= '<td>'.$row["team_name"].'</td>';
			$startDatatableHTML_participatingReleaseTrains .= '<td><a href="view.php?type=EMP&id='.urlencode($row["release_train_engineer"]).'">'.$row["release_train_engineer"].'</a></td>';
			$startDatatableHTML_participatingReleaseTrains .= '<td><a href="view.php?type=EMP&id='.urlencode($row["product_manager"]).'">'.$row["product_manager"].'</a></td>';
			$startDatatableHTML_participatingReleaseTrains .= '</tr>';
		}
		*/
		
		$startDatatableHTML_participatingReleaseTrains .= $endDatatableHTML;		
		
		$result->close();
		
		// check for unique locations
		if (count(array_unique($multipleLocations)) > 1) {
			$locationUnique = 'No';
		} else {
			$locationUnique = 'Yes';
		}
		
		// check if all roles are filled
		if (count(array_filter($allRoles)) < $numTeamMembers - 1) {
			$rolesFilled = 'No';
		} else {
			$rolesFilled = 'Yes';
		}
		
		// check if all certs are fileld
		if (count(array_filter($allCerts)) < $numTeamMembers - 1) {
			$certsFilled = 'No';
		} else {
			$certsFilled = 'Yes';
		}
		
		// output HTML string
		echo '<div class="container-fluid buffer">
		<div class="row">
			<div class="col-md-9">
				<h2><img height="50px" src="./icons/solution_train.png">Solution Train: '.$solutionTrainName.' </h2>
				<table class="table table-condensed table-bordered">
					<tr>
						<thead colspan="2"><h3>Information</h3></thead>
					</tr>
					<tr>
						<td style="width:200px;"> Team ID</td>
						<td>'.$teamID.'</td>
					</tr>
					<tr>
						<td>On Solution Train</td>
						<td>'.$solutionTrainName.'</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">	
			<div class="col-md-9">'.$startDatatableHTML_teamMembers.'
			</div>
		</div>
		<div class="row">	
			<div class="col-md-9">'.$startDatatableHTML_participatingReleaseTrains.'
			</div>
		</div>
		<div class="row">
			<div class="col-md-9">
				<table class="table table-condensed table-bordered">
					<tr>
						<thead colspan="2"><h3>SAFe Review Comments:</h3></thead>
					</tr>
					<tr>
						<td>Team Size</td>
						<td>'.$numTeamMembers.'</td>
					</tr>
					<tr>
						<td>All Roles Filled</td>
						<td>'.$rolesFilled.'</td>
					</tr>
					<tr>
						<td>All are trained</td>
						<td>'.$certsFilled.'</td>
					</tr>
					<tr>
						<td>Co-located</td>
						<td>'.$locationUnique.'</td>
					</tr>
				</table>
			</div>
		</div>
		<pre>'.$outputStuff.'</pre><div>'.$test.'</div>'; //Test Data
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
	
	/**
	* Simple function to display employees into table cell
	*/
	function employeeTable(&$ids, &$names, $type) {
		$html = '';
		$i=0;
		$length = count($ids);

		$html .= '<td>';
		for( $i; $i < $length; $i++) {
			$html .= '<a href="view.php?type='.$type.'&id='.$ids[$i].'">'.$names[$i].'</a><br>';
		}
		
		$html .= '</td>';
		return $html;
	}
?>