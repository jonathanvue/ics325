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
		require ('db_configuration.php');
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Capacity - Summary</title>
    
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
						<li><a href="capacity_activePI.php"><img src="./icons/capacity_active_pi.png" style="width:40px;height:50px;">Active PI</a></li>
						<li><a href="capacity_cadence.php"><img style="width:40px;height:50px;" src="./icons/capacity_cadence.png" />Cadence</a></li>
						<li><a href="capacity_calculate.php"><img class="icon" src="./icons/capacity_calculate.png" />Calculate</a></li>
						<li><a href="capacity_summary.php"><img src="./icons/capacity_summary.png" style="width:40px;height:50px;"/><img src="./icons/image15.png" style="width:20px;height:30px;">Summary</a></li>
						<li><a href="#"><img class="icon" src="./icons/capacity_trend.png" />Trend</a></li>
					</ul>
				</nav>
			</div>
			<div class="col-md-10">

				<table style="font-family:arial;" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered"
					   width="100%">

						<?php
							
							function getStartingIncrement()
							{
								$sql = "SELECT program_increment FROM cadence WHERE CURDATE() BETWEEN start_date AND end_date";
								$result = run_sql($sql);

								while($row = $result->fetch_assoc())
								{
									return $row["program_increment"];
								}	
							}

							function getPreviousIncrement()
							{


							}

							function getAllIncrements()
							{
								$sql = "SELECT DISTINCT program_increment FROM cadence";
								$result = run_sql($sql);

								while($row = mysql_fetch_assoc($result))
								{
									if(strcmp($row["program_increment"], $currentIncrement) > 0)
									{
										return $row["program_increment"];
									}
								}
							}

							function getNextIncrement($currentIncrement)
							{
								if($currentIncrement < getStartingIncrement())
								{
									$sql = "SELECT DISTINCT program_increment FROM cadence";
									$result = run_sql($sql);

									while($row = $result->fetch_assoc())
									{
										if(strcmp($row["program_increment"], $currentIncrement) > 0)
										{
											return $row["program_increment"];
										}
									}
								}
								else
								{
									return $currentIncrement;
								}
							}

							function getProgramIncrementTotal($currIncrement)
							{
								$sql = "SELECT total FROM capacity WHERE program_increment = '" . $currIncrement . "'";
								$result = run_sql($sql);

								$total = 0;

								while($row = $result->fetch_assoc())
								{
									$total += $row["total"];
								}

								return $total;
							}

							function previousTable()
							{

							}

							function nextTable()
							{
								getNextIncrement($currentIncrement);
							}

						?>


					<?php

						$team_id;

						if(isset($_GET["team_id"]))
						{
							$currIncrement = $_GET["team_id"];
						}
						else
						{
							$currIncrement = getStartingIncrement();
						}
						echo
							"<hr>
								<h3><font size=" . "'4'" . " color=" . "'blue'" . ">Capacity Roll-up</font></h3>
								<h4><font size=" . "'4'" . " color=" . "'black'" . ">For the entire Program Increment</font><font> = " .getProgramIncrementTotal($currIncrement) .  "</font></h4>	
							</hr>";

						echo 
							"<thead>
								<tr>
									<th>Type</th>
									<th>ID</th>
									<th>Name</th>
									<th>Scrum Master/RTE/STE</th>
									<th>". $currIncrement ."-1</th>
									<th>". $currIncrement ."-2</th>
									<th>". $currIncrement ."-3</th>
									<th>". $currIncrement ."-4</th>
									<th>". $currIncrement ."-5</th>
									<th>". $currIncrement ."-6</th>
									<th>Total</th>
								</tr>
							</thead>";

						//$team_id = $Get["team_id"];

						$pi = "pi-";
						$pi .= $currIncrement;	
						$sql = "SELECT t.type, c.team_id AS id, c.team_name AS name, m.role AS 'sm_rte_ste',
						iteration_1, iteration_2, iteration_3, iteration_4, iteration_5, iteration_6, total
						FROM capacity c 
						-- LEFT OUTER JOIN trains_and_teams t ON c.team_id = t.team_id
						LEFT OUTER JOIN (
						SELECT * FROM membership
						WHERE (
						role LIKE '%(SM)%'
						OR  role LIKE '%(STE)%'
						OR  role LIKE '%(RTE)%')) AS m ON c.team_id = m.team_id
						LEFT OUTER JOIN trains_and_teams t ON c.team_id = t.team_id
						WHERE program_increment = '" . $pi . "'";
						$result = run_sql($sql);
						
						// output data of each
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo '<tr>
									<td>' . $row["type"] . "</td>
									<td>" . $row["id"] . "</td>
									<td>" . $row["name"] . "</td>
									<td>" . $row["sm_rte_ste"] . "</td>
									<td>" . $row["iteration_1"] . "</td>
									<td>" . $row["iteration_2"] . "</td>
									<td>" . $row["iteration_3"] . "</td>
									<td>" . $row["iteration_4"] . "</td>
									<td>" . $row["iteration_5"] . "</td>
									<td>" . $row["iteration_6"] . "</td>
									<td>" . $row["total"] . "</td>
								</tr>";
						}
					} else {
						echo "0 results";
					}
					$result->close();
		?>
		</table>
		<?php echo "<a href=\"capacity_summary.php?team_id=" .getPreviousIncrement(preg_replace('/[^0-9]/', '', $currIncrement)-100). "\">Previous PI</a>"; ?>&nbsp;
		<?php echo "<a href=\"capacity_summary.php?team_id=" .getNextIncrement(preg_replace('/[^0-9]/', '', $currIncrement)+100). "\">Next PI</a>"; ?>
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