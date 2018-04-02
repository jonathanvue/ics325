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
    
	<!-- Latest compiled JavaScript  -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
				<li><a class="navImg" href="capacity_activePI.php"><img class="icon" src="./icons/capacity_active_pi.png" >Active PI</a></li>
				<li><a class="navImg" href="capacity_cadence.php"><img class="icon" src="./icons/capacity_cadence.png" />Cadence</a></li>
				<li><a class="navImg" href="capacity_calculate.php"><img class="icon" src="./icons/capacity_calculate.png" />Calculate</a></li>
				<li><a class="navImg" href="capacity_summary.php"><img class="icon" src="./icons/capacity_summary.png" />Summary</a></li>
				<li><a class="navImg" href="capacity_trend.php"><img class="icon" src="./icons/capacity_trend.png" /><img class="active" src="./icons/image15.png" />Trend</a></li>
			</ul>
		</div>
	</div>
	
	<!-- Primary content goes here -->
	<hr>
	<div class="container-fluid buffer">
		<h1>Capacity Trends for the Teams and Trains</h1>
		<div class="row">
			<div class="col-md-12">
				<div class="btn-group dropdown">
					<button type="button" class="btn btn-default">Solution Train</button>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="caret"></span>
						<span class="sr-only"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a href="#">Option 1</a></li>
						<li><a href="#">Option 2</a></li>
						<li><a href="#">Option 6</a></li>
						<li><a href="#">Option 10</a></li>
					</ul>
				</div>
				<div class="btn-group dropdown">
					<button type="button" class="btn btn-default">Agile Release Train</button>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="caret"></span>
						<span class="sr-only"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a href="#">ART 1</a></li>
						<li><a href="#">ART 2</a></li>
						<li><a href="#">ART 3</a></li>
						<li><a href="#">ART 4</a></li>
					</ul>
				</div>
				<div class="btn-group dropdown">
					<button type="button" class="btn btn-default">Agile Teams</button>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="caret"></span>
						<span class="sr-only"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a href="#">Team 1</a></li>
						<li><a href="#">Team 2</a></li>
						<li><a href="#">Team 3</a></li>
						<li><a href="#">Team 7</a></li>
					</ul>
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="container">
				<div class="jumbotron">
					<div class="container">
						<h1>Chart goes here</h1>
						<p>This is where all the fancy chart stuff would go after a user selects from the above buttons.</p>
						<p>For future reference: <a href="https://developers.google.com/chart/interactive/docs/php_example">Google Charts</a></p>
					</div>
				</div>
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