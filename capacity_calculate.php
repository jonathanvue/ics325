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
	<title>Capacity - Calculate</title>
    
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
	<div class="container">
	
		<div class="row">
			<div class="col-md-1">
				<nav class="nav-left">
					<ul class="nav nav-stacked">
						<li><a href="capacity_activePI.php"><img class="icon" src="./icons/capacity_active_pi.png">Active PI</a></li>
						<li><a href="capacity_cadence.php"><img class="icon" src="./icons/capacity_cadence.png" />Cadence</a></li>
						<li><a href="capacity_calculate.php"><img style="width:40px;height:50px;" src="./icons/capacity_calculate.png" /><img src="./icons/image15.png" style="width:20px;height:30px;">Calculate</a></li>
						<li><a href="capacity_summary.php"><img class="icon" src="./icons/capacity_summary.png"/>Summary</a></li>
						<li><a href="#"><img class="icon" src="./icons/capacity_trend.png" />Trend</a></li>
					</ul>
				</nav>
			</div>
			<div class="col-md-10">
			<hr>
			<h3><font size="4" color="blue">Capacity Calculations for the Agile Team</font></h3>
			<h4><font size="4" color="black">
			<table >
			<?php
						require 'db_configuration.php';
						
						$sql = "SELECT * FROM preferences, capacity INNER JOIN cadence ON capacity.program_increment = cadence.program_increment WHERE iteration = 'pi100-1' AND team_id = 'AT-710' AND preferences.name= 'OVERHEAD_PERCENTAGE'";
						$result = run_sql($sql);
						
						// output data of each
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo '
								<tr>	
									<td> Team: </td>
									<td>'. $row["team_name"] .'</td>
								</tr>';
								echo '
								<tr>	
									<td> Program Increment (PI): </td>
									<td>' . $row["program_increment"] . '</td>
								</tr>';
								echo '
								<tr>	
									<td> Iteration (I):  </td>
									<td>' . $row["iteration"] . '</td>
								</tr>';
								echo '
								<tr>	
									<td> No. of Days in the Iteration: </td>
									<td>'. $row["duration"] .'</td>
								</tr>';
								echo '
								<tr>	
									<td> Overhead Percentage: </td>
									<td>'. $row["value"] .'</td>
								</tr>';
							}
						} else {
							echo "0 results";
						}
						$result->close();
					?>
					</table></font></h4>
				
			</hr>	
				<table style="font-family:arial;" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered"
					   width="100%">
					    <thead>
							<tr>
								<th>Last Name</th>
								<th>First Name</th>
								<th>Role</th>
								<th>% Velocity Available</th>
								<th>Days Off (Vacation/Holidays/Sick Days)</th>
								<th>Story Points</th>
							</tr>
						</thead>
					<?php
						$sql = "SELECT * FROM membership WHERE team_name = 'Agile Team 710' ORDER BY role DESC";
						$result = run_sql($sql);
						
						// output data of each
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo '<tr>
									<td>' . $row["last_name"] . "</td>
									<td>" . $row["first_name"] . "</td>
									<td>" . $row["role"] . "</td>
									<td>" . $row["id"] . "</td>
									<td>" . $row["id"] . "</td>
									<td>" . $row["id"] . "</td>
								</tr>";
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