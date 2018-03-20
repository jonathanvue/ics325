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
    <!-- < ?PHP echo getTopNav(); ?> -->
	<nav class="navbar navbar-static-top" role="navigation">				
		<div class="container-fluid no-margin">
			<ul class="nav navbar-nav text-center">
				<li><a href="index.php"><img class="logo" src="./icons/image1.png" /></a>
					<div class="name-wrapper">
						<font class="nav-font">SAFe Explorer</font>
					</div>
				</li>
				<li><a class="navImg" href="trains_list.php"><img class="icon" src="./icons/image4.png" />Trains</a></li>
				<li><a class="navImg" href="org_list.php"><img class="icon" src="./icons/image2.png" />Org</a></li>
				<li><a class="navImg" href="capacity_activePI.php"><img class="icon" src="./icons/image6.png" />Capacity</a></li>
				<li><a class="navImg" href="#"><img class="icon" src="./icons/image10.png" />Training</a></li>
				<li><a class="navImg" href="#"><img class="icon" src="./icons/image5.png" />Reports</a></li>
				<li><a class="navImg" href="#"><img class="icon" src="./icons/admin.png" />Admin</a></li>
				<li><a class="navImg" href="#"><img class="icon" src="./icons/image7.png" />Login</a></li>
				<li><a class="navImg" href="#"><img class="icon" src="./icons/image8.png" />Help</a></li>
			</ul>
			<form class="navbar-form navbar-right">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-default">Submit</button>
			</form>
		</div>
	</nav>
	
	<!-- Side navigation to be placed into -->
	<div class="sideNav text-center">
		<div class="sideMenu">
			<ul class="sideMenuItem text-center">
				<li><a class="navImg" href="#" ><img class="icon" src="./icons/search_list.png" />List</a></li>
				<li><a class="navImg" href="#" ><img class="icon" src="./icons/org_lists.png" />Lists</a></li>
			</ul>
		</div>
	</div>
	
	<!-- Primary content goes here -->
	<div class="container buffer">
		<h1>This is the default landing page<p><small>Work in progress</small><p></h1>
	</div>
</body>
</html>