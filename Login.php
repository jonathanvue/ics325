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
	<title>Login</title>
    
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
		<hr>
		<h3><font size="6" color="blue">Login</font></h3>
		<hr>
		<div class="row">
			<div class="col-md-1">
				<nav class="nav-left">
					<ul class="nav nav-stacked">
						<li><a href="#">List</a></li>
						<li><a href="#">Grid</a></li>
					</ul>
				</nav>
			</div>
			<div class="col-md-10">
				<table style="font-family:arial;" id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered"
					   width="100%">
					 <colgroup>
						<col span="9" style="background-color:lightblue">
						<col style="background-color:yellow">
					</colgroup>
					<thead>
						<tr>
							<th>Employee_ID</th>
							<th>Last_Name</th>
							<th>First_Name</th>
							<th>City</th>
							<th>Country</th>
							<th>Manager_ID</th>
							<th>Email</th>
							<th>Cost_Center</th>
							<th>Status</th>
							<th>Primary_Team</th>
						</tr>
					</thead>
					<tbody>
					<?php
						require 'db_configuration.php';
						
						$sql = "SELECT * FROM organization_hierarchy";
						$result = run_sql($sql);
						
						// output data of each
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo '<tr>
									<td>' . $row["employee_id"] . "</td>
									<td>" . $row["last_name"] . "</td>
									<td>" . $row["first_name"] . "</td>
									<td>" . $row["city"] . "</td>
									<td>" . $row["country"] . "</td>
									<td>" . $row["manager_id"] . "</td>
									<td>" . $row["email_address"] . "</td>
									<td>" . $row["cost_center"] . "</td>
									<td>" . $row["status"] . "</td>
									<td>" . $row["primary_team"] . "</td>
								</tr>";
						}
					} else {
						echo "0 results";
					}
					$result->close();
		?>
					</tbody>
					<tfoot>
						<tr>
							<td>Employee_ID</td>
							<td>Last_Name</td>
							<td>First_Name</td>
							<td>City</td>
							<td>Country</td>
							<td>Manager_ID</td>
							<td>Email</td>
							<td>Cost_Center</td>
							<td>Status</td>
							<td>Primary_Team</td>
						</tr>
					</tfoot>
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
© 2018 GitHub, Inc.
Terms
Privacy
Security
Status
Help
Contact GitHub
API
Training
Shop
Blog
