<!DOCTYPE html>
<html>
<head>
	 <?PHP
    session_start();
    require('session_validation.php');
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAFe Explorer</title>
	
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
    <!-- < ?PHP echo getTopNav(); ?> -->
	<?PHP echo getTopNav(); ?>
	
	<!-- Side navigation to be placed into -->
	<div class="sideNav text-center">
		<div class="sideMenu">
			<ul class="sideMenuItem text-center">
				<li><a class="navImg" href="capacity_activePI.php"><img class="icon" src="./icons/capacity_active_pi.png" />Active PI</a></li>
				<li><a class="navImg" href="capacity_cadence.php"><img class="icon" src="./icons/capacity_cadence.png" />Cadence</a></li>
				<li><a class="navImg" href="capacity_calculate.php"><img class="icon" src="./icons/capacity_calculate.png" /><img class="active" src="./icons/image15.png" >Calculate</a></li>
				<li><a class="navImg" href="capacity_summary.php"><img class="icon" src="./icons/capacity_summary.png" />Summary</a></li>
				<li><a class="navImg" href="#"><img class="icon" src="./icons/capacity_trend.png" />Trend</a></li>
			</ul>
		</div>
	</div>
	
	<!-- Primary content goes here -->
	<div class="container buffer">
		<h1>Capacity<p><small>Calculate</small></p></h1>
		<p>This page will be called with the current iteration or called with URL parameter</p>
		<!-- Table to input data to pull in the datatables -->
		<div class="row">
			<div class="container-fluid">
				<table class="table" style="width: 800px;">
					<th colspan="2">
						Capacity Calculations for the Agile Team
					</th>
					<tr>
						<td>Team:</td>
						<td>(user input team)</td>
					</tr>
					<tr>
						<td>Program Increment (PI):</td>
						<td>(selection list of program increments not past end date)</td>
					</tr>
					<tr>
						<td>Iteration (I):</td>
						<td>(current iteration pulled from database)</td>
					</tr>
					<tr>
						<td>No. of Days in the iteration:</td>
						<td>(calculated iteration days between start and end date)</td>
					</tr>
					<tr>
						<td>Overhead Percentage:</td>
						<td>(default value from database)</td>
					</tr>
				</table>
			</div>
		</div>
		<!-- Datatable information goes below -->
		<div class="row">
			<div class="col-md-10">
				<table id="calc" class="datatable table table-striped table-bordered">
					<colgroup>
						<col span="9">
						<col>
					</colgroup>
					<thead>
						<tr>
							<th>Last Name</th>
							<th>First Name</th>
							<th>Role</th>
							<th>% Velocity</th>
							<th>Days Off</th>
							<th>Story Points</th>
						</tr>
					</thead>
					<tbody>
					<!-- php code to pull data from database -->
					<?php 
						echo '
						<tr>
							<td>Smith</td>
							<td>John</td>
							<td>SM</td>
							<td>100</td>
							<td>0</td>
							<td>8</td>
						</tr>
						'
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

			$('#calc').DataTable();

		});

	</script>
</body>
</html>