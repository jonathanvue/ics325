<!DOCTYPE html>
<html>
<head>
	 <?PHP
	    session_start();
	    require('session_validation.php');
		require('db_configuration.php');
		require('Employee.php');
		require('AgileTeams.php');
		require('AgileReleaseTrain.php');
		require('SolutionTrain.php');
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
		function createEmployee()
		{
			$tableObject;
			$sql;
		
			/*if (isset($_GET['type'])) {
				$type = $_GET['type'];
			}*/
			
			// Employees query
			if (count($_GET) == 0)
			{
				$sql = queryEmployeeNoParams();
			}
			else
			{
				if (isset($_GET["id"]) && isset($_GET["type"]))
				{
					$sql = queryEmployee($_GET["id"], $_GET["type"]);
				}
			}
					//$rows = $result->num_rows;
			
			// output data of each result
			if ($result = run_sql($sql))
			{
				while ($queryObject = $result->fetch_object())
				{
					/*
					* If URL params don't include ?type=###&id=#### then this is default display 
					* otherwise an object is created based upon the type of table needed
					*/
					if(count($_GET) == 0)
					{
						return $employee = new Employee($queryObject);
					}
					if($_GET["type"] === "EMP")
					{
						return $employee = new Employee($queryObject);
					}
					else if($_GET["type"] === "ART")
					{
						return $tableObject = new AgileReleaseTrain($queryObject);
					}
					else if($_GET["type"] === "AT")
					{
						return $tableObject = new AgileTeams($queryObject);
					}
					else if($_GET["type"] === "ST")
					{
						return $tableObject = new SolutionTrain($queryObject);
					}

					/*
					$empNbr = $result["employee_nbr"];
					$firstName = $result["first_name"];
					$lastName = $result["last_name"];
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
					*/
				}
			}
			
			$result->close();
		}
		
		function queryEmployeeNoParams()
		{
			return "SELECT e.employee_nbr,
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
		}

		function queryEmployee($id, $type)
		{
			return "SELECT e.employee_nbr,
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
	?>
	
	<div class="container-fluid buffer">
		<!-- Employee -->
		<div class="row">
			<div class="col-md-9">
				<table class="table table-condensed table-bordered">
					<tr>
						<thead colspan="2" ><h3>Employee</h3></thead>
					</tr>
					<tr>
						<td style="width:200px;">First Name</td>
						<td><?php $emp = createEmployee(); 
						echo $emp->getEmployeeNumber(); ?></td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td></td>
					</tr>
					<tr>
						<td>Email</td>
						<td></td>
					</tr>
					<tr>
						<td>City</td>
						<td></td>
					</tr>
					<tr>
						<td>Country</td>
						<td></td>
					</tr>
					<tr>
						<td>Manager's Name</td>
						<td></td>
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
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>Agile Release Train</td>
						<td></td>
						<td class="disabled"></td>
					</tr>
					<tr>
						<td>Solution Train</td>
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
						<thead colspan="2"><h3>Training</h3></thead>
					</tr>
					<tr>
						<td style="width:200px;">Status</td>
						<td></td>
					</tr>
					<tr>
						<td>Course Name</td>
						<td></td>
					</tr>
					<tr>
						<td>Course Code</td>
						<td></td>
					</tr>
					<tr>
						<td>Trainer</td>
						<td></td>
					</tr>
					<tr>
						<td>Dates</td>
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