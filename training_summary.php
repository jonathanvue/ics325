<?php
session_start();
require('session_validation.php');
require('db_configuration.php');
require('Employee.php');
require('AgileTeam.php');
require('AgileTeamView.php');
require('AgileReleaseTrain.php');
require('SolutionTrain.php');
require('ViewAgileTeams.php');
require('EmployeeView.php');
require('SolutionTrainView.php');
require('AgileReleaseTrainView.php');
echo getTopNav();

function createObject()
{
	$tableObject;
	$sql;

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
				$sql = Employee::queryEmployee($_GET["id"], $_GET["type"]); //Change to queryAgileTeam once implemented
			}
			else if($_GET["type"] === "ST")
			{
				$sql = Employee::queryEmployee($_GET["id"], $_GET["type"]); //Change to querySolutionTrain once implemented
			}
		}
	}

	// Create Object from Query data and return it.
	if ($result = run_sql($sql))
	{
		while ($queryObject = $result->fetch_object())
		{
			if($_GET["type"] === "EMP")
			{
				return $tableObject = new Employee($queryObject);
			}
			else if($_GET["type"] === "ART")
			{
				return $tableObject = new AgileReleaseTrain($queryObject);
			}
			else if($_GET["type"] === "AT")
			{
				return $tableObject = new AgileTeam($queryObject);
			}
			else if($_GET["type"] === "ST")
			{
				return $tableObject = new SolutionTrain($queryObject);
			}
			else
			{
				return null;
			}
		}
	}

	$result->close();
}

	function displayObject($emp)
	{
		if($emp instanceof Employee)
		{
			EmployeeView::instance()->displayHTML($emp);
		}
		elseif($emp instanceof AgileTeam)
		{
			AgileTeamView::instance()->displayHTML($emp);
		}
		elseif($emp instanceof SolutionTrain)
		{
			SolutionTrainView::instance()->displayHTML($emp);
		}
		elseif($emp instanceof AgileReleaseTrain)
		{
			AgileReleaseTrainView::instance()->displayHTML($emp);
		}
		else //No information retrieved
		{
			echo '<body><div class="container-fluid buffer"><strong>No Information Found</strong></div></body>';
		}
	}

/**
* Runner for the page. An object type is taken from the URL type= parameter and then queried for the 
* propper information to populate it. Then the Object is created and passed back. It is then displayed
*/
$emp = createObject();
displayObject($emp);

?>

<!-- Start of the HTML -->
<!DOCTYPE html>
<html>
<head>
	 <?PHP
   
    require('session_validation.php');
	require('db_configuration.php');
	require('view_functions.php');
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
		$type = $id = '';
	
		// Get params from url
		if (isset($_GET["id"])) {
			$id = strtolower($_GET["id"]);
		} 
		
		if (isset($_GET["type"])) {
			$type = strtolower($_GET["type"]);
		}
				
		// Query type check
		switch($type){
			case 'emp':
				emp_query($id);
				break;
			case 'at':
				at_query($id);
				break;
			case 'art':
				art_query($id);
				break;
			case 'st':
				st_query($id);
				break;
		}
	?>

	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function ()
		{
			$('#info').DataTable();
			$('#info2').DataTable();

		});
	</script>
</body>
</html>