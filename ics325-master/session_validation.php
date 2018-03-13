<?php
	/**
	 * Returns true if user has a valid
	 * session else false
	 */
	function sessionExists() {
		if ((isset($_SESSION['valid_user'])) && (($_SESSION['valid_user']) != null))  {
			return true;
		}
		else {
			return false;
		}
	}
	/**
	 * Returns true if user has a valid session
	 * and if the user is an admin
	 */
	function adminSessionExists() {
		if ((isset($_SESSION['valid_admin'])) && (($_SESSION['valid_admin']) != null)) {
			return true;
		}
		else{
			return false;
		}
	}
	/**
	 * Generates topnav to display admin topnav
	 * if admin is logged in else displays
	 * normal navbar
	 */
	function getTopNav() {
		$topNav = "";
		if (adminSessionExists()) {
			$topNav = '
				<nav class="navbar navbar-static-top" role="navigation">
					<div class="container">				
						<ul class="nav navbar-nav text-center">
							<li><a href="index.php"><img class="logo" src="./icons/image1.png" /></a>
								<div class="name-wrapper">
									<font class="nav-font">SAFe Explorer</font>
								</div>
							</li>
							<li><a class="navImg" href="#"><img class="icon" src="./icons/image4.png" /><div class="caption">Trains</div></a></li>
							<li><a class="navImg" href="org_list.php"><img class="icon" src="./icons/image2.png" />Org</a></li>
							<li><a class="navImg" href="#"><img class="icon" src="./icons/image6.png" />Capacity</a></li>
							<li><a class="navImg" href="#"><img class="icon" src="./icons/image10.png" />Training</a></li>
							<li><a class="navImg" href="#"><img class="icon" src="./icons/image5.png" />Reports</a></li>
							<li><a class="navImg" href="#"><img class="icon" src="./icons/image38.png" />Admin</a></li>
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
				</nav>';
		}
		else if (sessionExists()) {
			$topNav = '
				<nav class="navbar navbar-static-top" role="navigation">
					<div class="container">				
						<ul class="nav navbar-nav text-center">
							<li><a href="index.php"><img class="logo" src="./icons/image1.png" /></a>
								<div class="name-wrapper">
									<font class="nav-font">SAFe Explorer</font>
								</div>
							</li>
							<li><a class="navImg" href="#"><img class="icon" src="./icons/image4.png" /><div class="caption">Trains</div></a></li>
							<li><a class="navImg" href="org_list.php"><img class="icon" src="./icons/image2.png" />Org</a></li>
							<li><a class="navImg" href="#"><img class="icon" src="./icons/image6.png" />Capacity</a></li>
							<li><a class="navImg" href="#"><img class="icon" src="./icons/image10.png" />Training</a></li>
							<li><a class="navImg" href="#"><img class="icon" src="./icons/image5.png" />Reports</a></li>
							<li><a class="navImg" href="#"><img class="icon" src="./icons/image38.png" />Admin</a></li>
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
				</nav>';
		}
		else{
			$topNav = '
				<nav class="navbar navbar-static-top" role="navigation">
					<div class="container">				
						<ul class="nav navbar-nav text-center">
							<li><a href="index.php"><img class="logo" src="./icons/image1.png" /></a>
								<div class="name-wrapper">
									<font class="nav-font">SAFe Explorer</font>
								</div>
							</li>
							<li><a class="navImg" href="#"><img class="icon" src="./icons/image4.png" /><div class="caption">Trains</div></a></li>
							<li><a class="navImg" href="org_list.php"><img class="icon" src="./icons/image2.png" />Org</a></li>
							<li><a class="navImg" href="#"><img class="icon" src="./icons/image6.png" />Capacity</a></li>
							<li><a class="navImg" href="#"><img class="icon" src="./icons/image10.png" />Training</a></li>
							<li><a class="navImg" href="#"><img class="icon" src="./icons/image5.png" />Reports</a></li>
							<li><a class="navImg" href="#"><img class="icon" src="./icons/image38.png" />Admin</a></li>
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
				</nav>';
		}
		return $topNav;
	}
?>
