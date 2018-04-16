<!DOCTYPE html>
<html>
<head>
	 <?PHP
    session_start();
    require('session_validation.php');
	require('db_configuration.php');
	require('view_functions.php');
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
	<?php echo getTopNav(); ?>

	<!-- Primary content goes here -->
	<?php 
		$type = $id = '';
	
		// Get params from url
		if (isset($_GET["id"])) {
			$id = strtolower($_GET["id"]);
		} 
		
		if (isset($_GET["type"])) {
			$type = strtolower($_GET["type"]);
		}
				
		// Query type check
		switch($type){
			case 'emp':
				emp_query($id);
				break;
			case 'at':
				at_query($id);
				break;
			case 'art':
				art_query($id);
				break;
			case 'st':
				st_query($id);
				break;
			default:
				// Stuff
				break;
		}
		
	?>

	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript">

		$(document).ready(function () {

			$('#info').DataTable();
			$('#info2').DataTable();

		});

	</script>
</body>
</html>