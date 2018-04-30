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
	<title>Org List</title>
    
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
	
	<div class="container-fluid buffer">
		<hr>
		<h3>

			
<?php
$keywords = array();
$domain = array('http://www.google.com');
$doc = new DOMDocument;
$doc->preserveWhiteSpace = FALSE;
foreach ($domain as $key => $value) {
    @$doc->loadHTMLFile($value);
    $anchor_tags = $doc->getElementsByTagName('a');
    foreach ($anchor_tags as $tag) {
        $keywords[] = strtolower($tag->nodeValue);
    }
}
?>


<a href="<?php echo "http://www.google.com"; ?>">


</h3>
</div>

</script>
</body>
</html>