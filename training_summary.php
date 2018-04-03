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
		require('ViewAgileTeams.php');
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
			
			
			if (count($_GET) == 0) //Creates a display message that no information was found.
			{
				return null;
			}
			else  //If parameters are present, then an appropriate Object can be created.
			{
				if (isset($_GET["id"]) && isset($_GET["type"]))
				{
					if($_GET["type"] === "EMP")
					{
						$sql = Employee::queryEmployee($_GET["id"], $_GET["type"]);
					}
					else if($_GET["type"] === "ART")
					{
						$sql = AgileReleaseTrain::queryEmployee($_GET["id"], $_GET["type"]);
					}
					else if($_GET["type"] === "AT")
					{
						$sql = AgileTeams::queryEmployee($_GET["id"], $_GET["type"]);
					}
					else if($_GET["type"] === "ST")
					{
						$sql = SolutionTrain::queryEmployee($_GET["id"], $_GET["type"]);
					}
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
					/*
					if(count($_GET) == 0)
					{
						return $employee = new Employee($queryObject);
					}
					*/
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
					$role[] = $row["role"];
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
		

	?>

	<!-- HTML for displaying Objects. Use switch or if statement with class type.
	<div class="container-fluid buffer">
		<?php
			//If commenting out this div statement /**/ out the variable contained in here.
			/*
			$emp = createEmployee();
			$view = new ViewAgileTeams($emp);
			$view->displayHTML($emp);
			*/
		?>
	</div>-->


	<!-- Displays the tables with no gap between the navbar menu items and the first table header -->
		<?php
			$emp = createEmployee();

			if($emp instanceof Employee)
			{
				$emp->displayHTML();
			}
			elseif($emp instanceof AgileTeams)
			{

			}
			elseif($emp instanceof AgileReleaseTrain)
			{
				$emp->displayHTML();
			}
			else
			{
				echo '<body><div class="container-fluid buffer"><strong>No Information Found</strong></div></body>';
			}

		?>

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