<?php
	//require('db_configuration.php');
	
	/**
	* search_query - provides HTML template for a search query.
	* @param: $name - an employee name
	*/
	function search_query($name) {
		$startDatatableHTML = '<div class="container-fluid buffer">
			<!-- Search -->
			<div class="row">
				<div class="col-md-9">
					<h2>Search Page</h2>
						<table id="info" class="datatable table table-striped table-bordered">
							<thead>
								<tr>
									<th>ID</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Email</th>
									<th>City</th>
									<th>Country</th>
									<th>Status</th>
									<th>Primary Team</th>
								</tr>
							</thead>
							<tbody>';
		
		$middleDatatableHTML = '';
		
		$endDatatableHTML = '<tfoot></tfoot>
				</tbody>
			</table>';
			
		// Information query
		if(empty($name)) {
			$sql = "SELECT e.employee_nbr AS id,
					e.first_name,
					e.last_name,
					e.email_address AS email,
					e.city,
					e.country,
					e.status,
					m.team_name AS primary_team
				FROM employees e
				JOIN membership m ON m.employee_nbr = e.employee_nbr;";
		} else {
			$sql = "SELECT e.employee_nbr AS id,
					e.first_name,
					e.last_name,
					e.email_address AS email,
					e.city,
					e.country,
					e.status,
					m.team_name AS primary_team
				FROM employees e
				JOIN membership m ON m.employee_nbr = e.employee_nbr
				WHERE e.first_name LIKE '%".$name."%';";
		}
		
		$result = run_sql($sql);
		
		// Build table string
		
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$middleDatatableHTML .= '<tr>
						<td><a href="./training_summary.php?type=emp&id='.$row["id"].'">' . $row["id"] . "</a></td>
						<td>" . $row["first_name"] . "</td>
						<td>" . $row["last_name"] . "</td>
						<td>" . $row["email"] . "</td>
						<td>" . $row["city"] . "</td>
						<td>" . $row["country"] . "</td>
						<td>" . $row["status"] . "</td>
						<td>" . $row["primary_team"] . "</td>
					</tr>";
			}
		}
		
		// Output HTML string
		echo $startDatatableHTML . $middleDatatableHTML .$endDatatableHTML;
	}
	/**
	* emp_query - provides HTML template for an employee query.
	* @param: $id - an employee id
	*/
	function emp_query($id) {
		$sql = $result = $row = '';
		$empNbr = $firstName = $lastName = $emailAddress = $city = $country = '';
		$managerName = $agileTeamName = $agileReleaseTrainName = $solutionTrainName = '';
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
		echo '<div class="container-fluid buffer">
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
				SELECT 
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
				SELECT m.team_id, 
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
			$multipleLocations[] =$row["location"];
			$teamID = $row["team_id"];
			$allRoles[] = $row["role"];
			$allCerts[] = $row["certification"];
			
			$startDatatableHTML .= '<tr>';
			$startDatatableHTML .= '<td>'.$row["first_name"].'</td>';
			$startDatatableHTML .= '<td>'.$row["last_name"].'</td>';
			$startDatatableHTML .= '<td>'.$row["email_address"].'</td>';
			$startDatatableHTML .= '<td>'.$row["role"].'</td>';
			$startDatatableHTML .= '<td>'.$row["certification"].'</td>';
			$startDatatableHTML .= '<td>'.$row["location"].'</td>';
			$startDatatableHTML .= '</tr>';
			
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
				<table class="table table-condesnsed table-bordered">
					<tr>
						<thead colspan="2"><h3>Information</h3></thead>
					</tr>
					<tr>
						<td style="width:200px;"> Team ID</td>
						<td>'.$teamID.'</td>
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
							<th>Product Owner</th>
						</tr>
					</thead>
				<tbody>';
				
		$endDatatableHTML = '<tfoot></tfoot>
				</tbody>
			</table>';
			
		// Information query
		if(empty($id)) {
			$sql = "SELECT tt_art.team_id, tt_art.name AS name_art, tt_st.name AS name_st 
				FROM trains_and_teams tt_art
				JOIN trains_and_teams tt_st ON tt_art.parent = tt_st.team_id
				ORDER BY tt_art.team_id
				LIMIT 1";
		} else {
			$sql = "SELECT tt_art.team_id, tt_art.name AS name_art, tt_st.name AS name_st 
				FROM trains_and_teams tt_art
				JOIN trains_and_teams tt_st ON tt_art.parent = tt_st.team_id
				WHERE tt_art.team_id = '".$id."'";
		}
		
		// output data of each row
		$result = run_sql($sql);
		$row = $result->num_rows;
		
		while ($row = $result->fetch_assoc()){
			$agileReleaseTrainName = $row["name_art"];
			$solutionTrainName = $row["name_st"];
		}
		
		// Team members query
		if(empty($id)) {
			$sql = "
				SELECT 
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
				SELECT m.team_id, 
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
			$multipleLocations[] =$row["location"];
			$teamID = $row["team_id"];
			$allRoles[] = $row["role"];
			$allCerts[] = $row["certification"];
			
			$startDatatableHTML_teamMembers .= '<tr>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["first_name"].'</td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["last_name"].'</td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["email_address"].'</td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["role"].'</td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["certification"].'</td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["location"].'</td>';
			$startDatatableHTML_teamMembers .= '</tr>';
			
			$numTeamMembers++;
		}
		$startDatatableHTML_teamMembers .= $endDatatableHTML;
		
		// Participating Agile Release Train query
		if(empty($id)){
			$sql = "SELECT m.team_id, m.team_name, s.scrum_master, p.product_owner
				FROM membership m
				LEFT OUTER JOIN (
					SELECT team_id, CONCAT(first_name, ' ', last_name) AS scrum_master
					FROM membership
					WHERE role LIKE '%scrum_master%'
					) s ON m.team_id = s.team_id
				LEFT OUTER JOIN (
					SELECT team_id, CONCAT(first_name, ' ', last_name) AS product_owner 
					FROM membership
					WHERE role LIKE '%Product Owner%'
					) p ON m.team_id = p.team_id
				GROUP BY m.team_id, m.team_name, s.scrum_master, p.product_owner
				ORDER BY m.team_id
				LIMIT 1";
		} else {
			$sql = "SELECT m.team_id, m.team_name, s.scrum_master, p.product_owner
				FROM membership m
				LEFT OUTER JOIN (
					SELECT team_id, CONCAT(first_name, ' ', last_name) AS scrum_master
					FROM membership
					WHERE role LIKE '%scrum_master%'
					) s ON m.team_id = s.team_id
				LEFT OUTER JOIN (
					SELECT team_id, CONCAT(first_name, ' ', last_name) AS product_owner 
					FROM membership
					WHERE role LIKE '%Product Owner%'
					) p ON m.team_id = p.team_id
				WHERE m.team_id IN (
					SELECT team_id 
					FROM trains_and_teams
					WHERE parent LIKE '%".$id."')
				GROUP BY m.team_id, m.team_name, s.scrum_master, p.product_owner";
		}
		
		$result = run_sql($sql);
		$row = $result->num_rows;
		
		while ($row = $result->fetch_assoc()){
			$startDatatableHTML_participatingAgileTeams .= '<tr>';
			$startDatatableHTML_participatingAgileTeams .= '<td>'.$row["team_id"].'</td>';
			$startDatatableHTML_participatingAgileTeams .= '<td>'.$row["team_name"].'</td>';
			$startDatatableHTML_participatingAgileTeams .= '<td>'.$row["scrum_master"].'</td>';
			$startDatatableHTML_participatingAgileTeams .= '<td>'.$row["product_owner"].'</td>';
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
				<h2><img height="50px" src="./icons/agile_release_train.png">Agile Team: '.$agileReleaseTrainName.' </h2>
				<table class="table table-condesnsed table-bordered">
					<tr>
						<thead colspan="2"><h3>Information</h3></thead>
					</tr>
					<tr>
						<td style="width:200px;"> Team ID</td>
						<td>'.$teamID.'</td>
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
			<div class="col-md-9">'.$startDatatableHTML_teamMembers.'
			</div>
		</div>
		<div class="row">	
			<div class="col-md-9">'.$startDatatableHTML_participatingAgileTeams.'
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
							<th>Product Owner</th>
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
				SELECT 
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
				SELECT m.team_id, 
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
			$multipleLocations[] =$row["location"];
			$teamID = $row["team_id"];
			$allRoles[] = $row["role"];
			$allCerts[] = $row["certification"];
			
			$startDatatableHTML_teamMembers .= '<tr>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["first_name"].'</td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["last_name"].'</td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["email_address"].'</td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["role"].'</td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["certification"].'</td>';
			$startDatatableHTML_teamMembers .= '<td>'.$row["location"].'</td>';
			$startDatatableHTML_teamMembers .= '</tr>';
			
			$numTeamMembers++;
		}
		$startDatatableHTML_teamMembers .= $endDatatableHTML;
		
		// Participating Agile Release Train query
		if(empty($id)){
			$sql = "SELECT m.team_id, m.team_name, r.release_train_engineer, p.product_owner
				FROM membership m
				LEFT OUTER JOIN (
					SELECT team_id, CONCAT(first_name, ' ', last_name) AS release_train_engineer
					FROM membership
					WHERE role LIKE '%Release Train Engineer%'
					) r ON m.team_id = r.team_id
				LEFT OUTER JOIN (
					SELECT team_id, CONCAT(first_name, ' ', last_name) AS product_owner 
					FROM membership
					WHERE role LIKE '%Product Owner%'
					) p ON m.team_id = p.team_id
				WHERE m.team_id IN (
					SELECT team_id 
					FROM trains_and_teams
					WHERE parent LIKE '%st-100%')
				GROUP BY m.team_id, m.team_name, r.release_train_engineer, p.product_owner
				ORDER BY m.team_id
				LIMIT 1";
		} else {
			$sql = "SELECT m.team_id, m.team_name, r.release_train_engineer, p.product_owner
				FROM membership m
				LEFT OUTER JOIN (
					SELECT team_id, CONCAT(first_name, ' ', last_name) AS release_train_engineer
					FROM membership
					WHERE role LIKE '%Release Train Engineer%'
					) r ON m.team_id = r.team_id
				LEFT OUTER JOIN (
					SELECT team_id, CONCAT(first_name, ' ', last_name) AS product_owner 
					FROM membership
					WHERE role LIKE '%Product Owner%'
					) p ON m.team_id = p.team_id
				WHERE m.team_id IN (
					SELECT team_id 
					FROM trains_and_teams
					WHERE parent LIKE '%".$id."%')
				GROUP BY m.team_id, m.team_name, r.release_train_engineer, p.product_owner";
		}
		
		$result = run_sql($sql);
		$row = $result->num_rows;
		
		while ($row = $result->fetch_assoc()){
			$startDatatableHTML_participatingReleaseTrains .= '<tr>';
			$startDatatableHTML_participatingReleaseTrains .= '<td>'.$row["team_id"].'</td>';
			$startDatatableHTML_participatingReleaseTrains .= '<td>'.$row["team_name"].'</td>';
			$startDatatableHTML_participatingReleaseTrains .= '<td>'.$row["release_train_engineer"].'</td>';
			$startDatatableHTML_participatingReleaseTrains .= '<td>'.$row["product_owner"].'</td>';
			$startDatatableHTML_participatingReleaseTrains .= '</tr>';
		}
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
				<h2><img height="50px" src="./icons/solution_train.png">Agile Team: '.$solutionTrainName.' </h2>
				<table class="table table-condesnsed table-bordered">
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
				<table class="table table-condesnsed table-bordered">
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
		</div>';
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