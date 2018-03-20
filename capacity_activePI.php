<?php //include 'navbar.php';
// Start session to store variables
if (!isset($_SESSION)) {
    session_start();
}
// Allows user to return 'back' to this page
?>

<!DOCTYPE html>

<html>

<head>
	<?PHP
		require('session_validation.php');
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Capacity - Active PI</title>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.min.css"
          rel="stylesheet"/>
		  
	<!-- Team created css -->
	<link rel="stylesheet" href="./styles/navbar_helper.css">
</head>

<body>
    <?PHP echo getTopNav(); ?>
	<!-- Side navigation to be placed into -->
	<div class="sideNav text-center">
		<div class="sideMenu">
			<ul class="sideMenuItem text-center">
				<li><a class="navImg" href="capacity_activePI.php"><img class="icon" src="./icons/capacity_active_pi.png"><img class="active" src="./icons/image15.png" >Active PI</a></li>
				<li><a class="navImg" href="capacity_cadence.php"><img class="icon" src="./icons/capacity_cadence.png" />Cadence</a></li>
				<li><a class="navImg" href="capacity_calculate.php"><img class="icon" src="./icons/capacity_calculate.png" />Calculate</a></li>
				<li><a class="navImg" href="capacity_summary.php"><img class="icon" src="./icons/capacity_summary.png" />Summary</a></li>
				<li><a class="navImg" href="#"><img class="icon" src="./icons/capacity_trend.png" />Trend</a></li>
			</ul>
		</div>
	</div>
	
	<!-- Primary content goes here -->
	<div class="container-fluid buffer">
		<div class="row">
			<div class="col-md-12">
				<table style="font-family:arial;" id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered"
					   width="100%">		
					
						<tr>
							<th colspan="2">Current Iteration Details</th>
						</tr>
					<?php
					$pi = $date = '';
					require 'db_configuration.php';
						echo '<tr>
						<td>Todays Date</td>
						<td>' . date("m/d/Y") . '</td>
						</tr>';		
						
						$sql = "SELECT * FROM cadence WHERE NOW() BETWEEN start_date AND end_date";
						$result = run_sql($sql);
						
						
						// output data of each
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								$pi = $row["program_increment"];
								$date = new DateTime($row["end_date"]);
								
								echo '
								<tr>	
									<td> Program Increment (PI) </td>
									<td>' . $row["program_increment"] . '</td>
								</tr>';
								echo '
								<tr>	
									<td> Iteration (I)  </td>
									<td>' . $row["iteration"] . '</td>
								</tr>';
								echo '
								<tr>	
									<td> Current Iteration Ends on  </td>
									<td>'. date_format($date, "m/d/Y") .'</td>
								</tr>';
								
								
						}
					} else {
						echo "0 results";
					}
					$result->close();
					
						$sql = "SELECT program_increment, MAX(end_date) AS end_date FROM cadence WHERE program_increment = '". $pi ."' GROUP BY program_increment";
						$result = run_sql($sql);
						
						
						// output data of each
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								$date = new DateTime($row["end_date"]);
								
								echo '
								<tr>	
									<td> Current Program Increment Ends on </td>
									<td>' . date_format($date, "m/d/Y") . '</td>
								</tr>';
						}
					} else {
						echo "0 results";
					}
					$result->close();
		?>
		
		</table>
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