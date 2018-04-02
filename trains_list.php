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
				<li><a class="navImg" href="trains_list.php"><img src="./icons/search_list.png" class="icon"><img class="active" src="./icons/image15.png" >List</a></li>
				<li><a class="navImg" href="trains_lists.php"><img class="icon" src="./icons/org_lists.png" />Lists</a></li>
				<li><a class="navImg" href="#"><img class="icon" src="./icons/image12.png" />Grid</a></li>
				<li><a class="navImg" href="#"><img class="icon" src="./icons/image14.png" />Tree</a></li>
				<li><a class="navImg" href="#"><img class="icon" src="./icons/image13.png" />Hybrid</a></li>
			</ul>
		</div>
	</div>
	
	<!-- Primary content goes here -->
	<div class="container-fluid buffer">
		<hr>
		<h3>
			<img class="small" src="./icons/image16.png" >Solution Trains (ST), 
			<img class="small" src="./icons/image17.png"/>Agile Release Trains (ART), 
			<img class="small" src="./icons/image20.png" />Agile Teams (AT)
		</h3>
		<hr>
		<div class="row">
			
			<div class="col-md-12">
				<table style="font-family:arial;" id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered"
					   width="100%">
					 <colgroup>
						<col span="9" style="background-color:lightblue">
						<col style="background-color:yellow">
					</colgroup>
					<thead>
						<tr>
							<th>Type</th>
							<th>ID</th>
							<th>Name</th>
							<th>Scrum Master/RTE/STE</th>
							<th>PM/PO</th>
							<th>Parent</th>
						</tr>
					</thead>
					<tbody>
					<?php
						require 'db_configuration.php';
						
						$sql = "SELECT * FROM trains_and_teams";
						$result = run_sql($sql);
						
						// output data of each
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo '<tr>
									<td>' . $row["type"] . "</td>
									<td>" . $row["team_id"] . "</td>
									<td>" . $row["name"] . "</td>
									<td>" . $row["name"] . "</td>
									<td>" . $row["parent"] . "</td>
									<td>" . $row["parent"] . "</td>
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