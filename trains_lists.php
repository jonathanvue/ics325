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
	<title>Trains</title>
    
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
				<li><a class="navImg" href="trains_list.php"><img src="./icons/search_list.png" class="icon" />List</a></li>
				<li><a class="navImg" href="trains_lists.php"><img class="icon" src="./icons/org_lists.png" /><img src="./icons/image15.png" style="width:20px;height:20px;"/>Lists</a></li>
				<li><a class="navImg" href="#"><img class="icon" src="./icons/image12.png" />Grid</a></li>
				<li><a class="navImg" href="#"><img class="icon" src="./icons/image14.png" />Tree</a></li>
				<li><a class="navImg" href="#"><img class="icon" src="./icons/image13.png" />Hybrid</a></li>
			</ul>
		</div>
	</div>
	
	<!-- Primary content goes here -->
	<div class="container buffer">
		<div class="row">
			<div class="col-md-10">
				<table style="font-family:arial;" id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered"
					   width="100%">
					 <colgroup>
						<col span="9" style="background-color:lightblue">
						<col style="background-color:yellow">
					</colgroup>
					
					<img class="small float" src="./icons/image16.png"/>
					<h3 class="float">Solution Trains (ST) </h3>
						
					<tbody>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>STE</th>
							<th>PM</th>
							<th>Solution Architect</th>
						</tr>
					<?php
						require 'db_configuration.php';
						
						$sql = "SELECT * FROM trains_and_teams LIMIT 3";
						$result = run_sql($sql);
						
						// output data of each
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo '<tr>
									<td>' . $row["team_id"] . "</td>
									<td>" . $row["type"] . "</td>
									<td>" . $row["name"] . "</td>
									<td>" . $row["name"] . "</td>
									<td>" . $row["name"] . "</td>
								</tr>";
						}
					} else {
						echo "0 results";
					}
					$result->close();
		?>
		</table>
		<table style="font-family:arial;" id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered"
					   width="100%">
					    <colgroup>
							<col span="9" style="background-color:lightblue">
							<col style="background-color:yellow">
						</colgroup>
						<img class="small float" src="./icons/image17.png"/>
						<h3 class="float">Agile Release Trains (ART)</h3>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>RTE</th>
							<th>PM</th>
							<th>Solution Train</th>
						</tr>
						<?php
						
						
						$sql = "SELECT * FROM trains_and_teams LIMIT 5";
						$result = run_sql($sql);
						
						// output data of each
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo '<tr>
									<td>' . $row["team_id"] . "</td>
									<td>" . $row["type"] . "</td>
									<td>" . $row["name"] . "</td>
									<td>" . $row["name"] . "</td>
									<td>" . $row["name"] . "</td>
								</tr>";
						}
					} else {
						echo "0 results";
					}
					$result->close();
		?>
		</table>
		<table style="font-family:arial;" id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered"
					   width="100%">
					    <colgroup>
							<col span="9" style="background-color:lightblue">
							<col style="background-color:yellow">
						</colgroup>
						<img class="small float" src="./icons/image20.png" />
						<h3 class="float">Agile Teams (AT)</h3>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Scrum Master</th>
							<th>Product Owner</th>
							<th>ART</th>
						</tr>
		<?php
						
						
						$sql = "SELECT * FROM trains_and_teams LIMIT 5";
						$result = run_sql($sql);
						
						// output data of each
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo '<tr>
									<td>' . $row["team_id"] . "</td>
									<td>" . $row["type"] . "</td>
									<td>" . $row["name"] . "</td>
									<td>" . $row["name"] . "</td>
									<td>" . $row["name"] . "</td>
								</tr>";
						}
					} else {
						echo "0 results";
					}
					$result->close();
		?>
					</tbody>
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