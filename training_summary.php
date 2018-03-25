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
    <title>SAFe Explorer</title>
	
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
		$firstName = $lastName = $emailAddress = $city = $country = $managerName = '';
		$team = $teamName = $role = '';
		$status = $courseName = $courseCode = $trainer = $dates = '';
		$type = $id = '';
		
		if (isset($_GET['type'])) {
			$type = $_GET['type'];
		}
		
		if (isset($_GET["id"])) {
			$id = $_GET["id"];
		}
		
		$sql = "SELECT e.first_name, 
			e.last_name, 
			e.email_address, 
			e.city, 
			e.country, 
			CONCAT(m.first_name, ' ', m.last_name) AS manager_name,
			mt.team,
			mt.team_name,
			mt.role,
			tec.status, 
			tec.course_name, 
			tec.course_code, 
			tec.trainer,
			tec.dates
		FROM employees e
		LEFT OUTER JOIN employees m ON e.managers_nbr = m.employee_nbr
		LEFT OUTER JOIN (
			SELECT employee_nbr,
				CASE
					WHEN type = 'AT' THEN 'Agile Team'
					WHEN type = 'ART' THEN 'Agile Release Train'
					WHEN type = 'ST' THEN 'Solution Train'
				END AS Team,
				name AS 'team_name',
				role
			FROM trains_and_teams t
			JOIN membership m
			ON t.team_id = m.team_id
			) mt ON e.employee_nbr = mt.employee_nbr
		LEFT OUTER JOIN (
			SELECT te.first_name, te.last_name, tc.status, tc.course_name, tc.course_code, CONCAT(tc.trainer_first_name, ' ', tc.trainer_last_name) AS trainer,
				CONCAT(DATE_FORMAT(tc.start_date, '%m/%d/%Y'), ' - ', DATE_FORMAT(tc.end_date, '%m/%d/%Y')) AS dates
			FROM training_calendar tc
			JOIN training_enrollment te ON tc.training_id = te.training_id
			) tec ON (e.first_name = tec.first_name AND e.last_name = tec.last_name)
		WHERE e.employee_nbr LIKE '%".$id."' 
		;
		";
		
		
		// Need to check against SQL injection one day...
		$result = run_sql($sql);
		
		// output data of each row
		if ($result->num_rows > 0) {
			while ($row=$result->fetch_assoc()) {
				$firstName = $row["first_name"];
				$lastName = $row["last_name"];
				$emailAddress = $row["email_address"];
				$city = $row["city"];
				$country = $row["country"];
				$managerName = $row["manager_name"];
				$team= $row["team"];
				$teamName = $row["team_name"];
				$role = $row["role"];
				$status = $row["status"];
				$courseName = $row["course_name"];
				$courseCode = $row["course_code"];
				$trainer = $row["trainer"];
				$dates = $row["dates"];
			}
		}
		
	?>
	
	<div class="container-fluid buffer">
		<!-- Employee -->
		<div class="row">
			<div class="col-md-9">
				<table class="table table-condensed table-bordered">
					<tr>
						<thead colspan="2"><h3>Employee</h3></thead>
					</tr>
					<tr>
						<td>First Name</td>
						<td><?php echo $firstName ?></td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td><?php echo $lastName ?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><?php echo $emailAddress ?></td>
					</tr>
					<tr>
						<td>City</td>
						<td><?php echo $city ?></td>
					</tr>
					<tr>
						<td>Country</td>
						<td><?php echo $country ?></td>
					</tr>
					<tr>
						<td>Manager's Name</td>
						<td><?php echo $managerName ?></td>
					</tr>
				</table>
			</div>
		</div>
		
		<!-- Teams -->
		<div class="row">
			<div class="col-md-9">
				<table class="table table-condensed table-bordered">
					<tr>
						<thead colspan="2"><h3>Teams</h3></thead>
					</tr>
					<tr>
						<th>Team</th>
						<th>Team Name</th>
						<th>Role</th>
					</tr>
					
					<tr>
						<td></td>
						<td></td>
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
						<thead><h3>Training</h3></thead>
					</tr>
					<tr>
						<td>Status</td>
						<td><?php echo $status ?></td>
					</tr>
					<tr>
						<td>Course Name</td>
						<td><?php echo $courseName ?></td>
					</tr>
					<tr>
						<td>Course Code</td>
						<td><?php echo $courseCode ?></td>
					</tr>
					<tr>
						<td>Trainer</td>
						<td><?php echo $trainer ?></td>
					</tr>
					<tr>
						<td>Dates</td>
						<td><?php echo $dates ?></td>
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