<!DOCTYPE html>
<html>
<head>
	 <?PHP
    session_start();
    require('session_validation.php');
	require('db_configuration.php')
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View - ART</title>
	
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
	<!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    
	<!-- Latest compiled JavaScript 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	-->
	<!-- Team created css -->
	<link rel="stylesheet" href="./styles/navbar_helper.css">
</head>
<body>
    <!-- < ?PHP echo getTopNav(); ?> -->
	<?php echo getTopNav(); ?>
	<!-- Side navigation to be placed into -->
	<div class="sideNav text-center">
		<div class="sideMenu">
			<ul class="sideMenuItem text-center">
				<li><a class="navImg" href="training_summary.php" ><img class="icon" src="./icons/training_summary.png" /><img class="active" src="./icons/image15.png" />Summary</a></li>
				<li><a class="navImg" href="training_calendar.php" ><img class="icon" src="./icons/training_calendar.png" />Calendar</a></li>
				<li><a class="navImg" href="training_roles.php" ><img class="icon" src="./icons/training_roles.png" />Roles</a></li>
				<li><a class="navImg" href="training_update.php" ><img class="icon" src="./icons/training_update.png" />Update</a></li>
				<li><a class="navImg" href="training_costs.php" ><img class="icon" src="./icons/training_costs.png" />Costs</a></li>
			</ul>
		</div>
	</div>
	
	<!-- Primary content goes here -->
	<?php
		function displayValues(&$array) {
			$array = array_unique($array);
			
			foreach($array as $v) {
				echo $v."<br>";
			}
		}
	?>
<!--
	<?php
		$empNbr = $firstName = $lastName = $emailAddress = $city = $country = $managerName = $employeeType = '';
		$agileTeamName = $agileReleaseTrainName = $solutionTrainName = '';
		$role = $status = $courseName = $courseCode = $trainer = $dates = array();
		$type = $id = $rows = '';
		
		if (isset($_GET['type'])) {
			$type = $_GET['type'];
		}
		
		// Employees query
		if (count($_GET) == 0) {
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
				LIMIT 1
				";
		} else {
			if (isset($_GET["id"])) {
				$id = $_GET["id"];
			}

			if(isset($_GET["type"])){
				$employeeType = $_GET["type"];
			}
			
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
			WHERE e.employee_nbr LIKE '%".$id."' ";
			
			// other parameters added here
			if (!empty($type)) {
				$sql .= "AND e.status LIKE '%".$employeeType."%' ";
			}
		}
		
		// Need to check against SQL injection one day...
		$result = run_sql($sql);
		$rows = $result->num_rows;
		
		// output data of each row
		if ($result->num_rows > 0) {
			while ($row=$result->fetch_assoc()) {
				$empNbr = $row["team_id"];
				$firstName = $row["art_name"];
				$lastName = $row["solution_train"];
				$emailAddress = $row["first_name"];
				$city = $row["last_name"];
				$country = $row["email"];
				$managerName = $row["role"];
				$agileTeamName = $row["certifications"];
				$agileReleaseTrainName = $row["location"];


				$solutionTrainName = $row["team_id"];
				$role[] = $row["team_name"];
				$status[] = $row["scrum_master"];
				$courseName[] = $row["product_owner"];
				$courseCode[] = $row["team_size"];
				$trainer[] = $row["all_roles_filled"];
				$dates[] = $row["all_are_trained"];
				$colocated[] = $row["colocated"];
			}
		}
		
		$result->close();	
		
	?>
-->
	
	<div class="container-fluid buffer">
		<!-- Information -->
		<div class="row">
			<div class="col-md-9">
				<table class="table table-condensed table-bordered">
					<tr>
						<thead colspan="2" ><h3>Information:</h3></thead>
					</tr>
					<tr>
						<th style="width:200px;">Team ID</th>
						<td></td>
					</tr>
					<tr>
						<th>Agile Release Train (ART) Name</th>
						<td></td>
					</tr>
					<tr>
						<th>On Solution Train</th>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
		
		<!-- Team Members -->
		<div class="row">
			<div class="col-md-9">
				<table class="table table-condensed table-bordered">
					<tr>
						<thead colspan="3" ><h3>Team Members (*): </h3></thead>
					</tr>
					<tr>
						<th style="width:200px;">First Name</th>
						<th>Last Name</th>
						<th>Email</th>
						<th>Role</th>
						<th>Certifications</th>
						<th>Location</th>
					</tr>
					
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
		
		<!-- Team Members -->
		<div class="row">
			<div class="col-md-9">
				<table class="table table-condensed table-bordered">
					<tr>
						<thead colspan="3" ><h3>Participating Agile Teams (*): </h3></thead>
					</tr>
					<tr>
						<th style="width:200px;">Team ID</th>
						<th>Team Name</th>
						<th>Scrum Master</th>
						<th>Product Owner</th>
					</tr>
					
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>

					</tr>
				</table>
			</div>
		</div>
		
		<!-- SAFe Review Comments -->
		<div class="row">
			<div class="col-md-9">
				<table class="table table-condensed table-bordered">
					<tr>
						<thead colspan="2" ><h3>SAFe Review Comments:</h3></thead>
					</tr>
					<tr>
						<th style="width:200px;">Team Size</th>
						<td></td>
					</tr>
					<tr>
						<th>All Roles Filled</th>
						<td></td>
					</tr>
					<tr>
						<th>All Are Trained</th>
						<td></td>
					</tr>
					<tr>
						<th>Co-Located</th>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript">

		$(document).ready(function () {

			$('#info').DataTable();

		});

	</script>
</body>
</html>