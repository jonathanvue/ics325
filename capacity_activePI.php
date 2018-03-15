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
	<div class="container">
		<div class="row">
			<div class="col-md-1">
				<nav class="nav-left">
					<ul class="nav nav-stacked">
						<li><a href="capacity_activePI.php"><img src="./icons/capacity_active_pi.png" style="width:40px;height:50px;"><img src="./icons/image15.png" style="width:20px;height:30px;">Active PI</a></li>
						<li><a href="capacity_cadence.php"><img class="icon" src="./icons/capacity_cadence.png" />Cadence</a></li>
						<li><a href="capacity_calculate"><img class="icon" src="./icons/capacity_calculate.png" />Calculate</a></li>
						<li><a href="capacity_summary.php"><img class="icon" src="./icons/capacity_summary.png" />Summary</a></li>
						<li><a href="#"><img class="icon" src="./icons/capacity_trend.png" />Trend</a></li>
					</ul>
				</nav>
			</div>
			<div class="col-md-10">
				<table style="font-family:arial;" id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered"
					   width="100%">		
						<tr>
							<th >Current Iteration Details</th>
						</tr>
						<tr>
							<td>Today's Date</td>
							<td>date</td> <!--Need php get date-->
						</tr>
						<tr>
							<td>Program Increment (PI)</td>
							<td>pi</td> <!--Need php-->
						</tr>
						<tr>
							<td>Iteration (I)</td>
							<td>iteration</td> <!--Need php-->
						</tr>
						<tr>
							<td>Current Iteration Ends on</td>
							<td>date (numberOfDays)</td> <!--Need php-->
						</tr>
						<tr>
							<td>Current Program Increment Ends on</td>
							<td>date (numberOfDays)</td> <!--Need php-->
						</tr>
						<!--<?php
						require 'db_configuration.php';
						
						$sql = "SELECT * FROM trains_and_teams LIMIT 5";
						$result = run_sql($sql);
						
						// output data of each
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo '
								<tr>	
									<td>' . $row["team_id"] . "</td>
									<td>" . $row["type"] . "</td>
								</tr>";
						}
					} else {
						echo "0 results";
					}
					$result->close();
		?>-->
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