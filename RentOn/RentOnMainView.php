<?php 

	require_once 'RentOnController.php';
	session_start();
	$controllerObj = new Controller();
	if(!empty($_SESSION['loginName'])) {
		$userName = $_SESSION['loginName'];
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>RentOn</title>
<link rel = "stylesheet" href="bootstrap.css">
<link rel = "stylesheet" href="rentOn.css">
<script src="jQuery.js"></script>

</head>
<body>
	<nav class="navbar bg-success">
		<form class="form-inline" action="RentOnSearch.php" method = "GET">
		<div class="container-fluid">
		<div class="navbar-header">
		<a class="navbar-brand" href = "RentOnHome.php">RentOn</a>
		</div>
		
		<div class="form-group" id = "searchField">
			<input type="text" name = "searchField" class="form-control" size = "30" placeholder="Where do you search house?">
			<button class="btn btn-primary" type="submit">Search</button>
			<a data-toggle = "collapse" data-target = "#search">more options</a>
		</div>						 
		<ul class="nav navbar-nav navbar-right">
			<?php 
				if(!empty($userName)){
					$newMessageCounter = $controllerObj->getMessageCounter("reciever = '$userName' and new = true");
					?>
					<li>
					<div class="dropdown">
						<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style = "margin:7px;"><?php echo $userName ?>
						<span class="caret"></span></button>
						<ul class="dropdown-menu">
							<li><a href = "RentOnMyAdv.php">My Advertisements</a></li>
							<li><a href = "RentOnMessages.php?view=recieved">Messages <span class = "signedData"><b><?php echo $newMessageCounter?></b></span></a></li>
							<li><a href = "RentOnUserRegistration.php">Data modification</a></li>
							<li><a href = "RentOnExit.php">Logout</a></li>
						</ul>
					</div>
					</li>
					<?php
				} else {
			?>
			<li><a href="RentOnUserRegistration.php?accountEmail=null"><img src = "icons/glyphicons-400-registration-mark.png"> Sign Up</a></li>
			<li><a href="RentOnLogin.php"><img src = "icons/glyphicons-387-log-in.png"> Login</a></li>
			<?php
				}
			?>
			
		</ul>
		</div>
		<div id="search" class="collapse">
			<div class = "form-group">
			<label for = "prize">Prize</label>
			<input class = "form-control" type = "number" name = "prizeMinSearch" placeholder = "min"/>
			-
			<input class = "form-control" type = "number" name = "prizeMaxSearch" placeholder = "max"/>
			</div>
			<div class = "form-group">
			<label for = "size">Size</label>
			<input class = "form-control" type = "number" name = "sizeMinSearch" placeholder = "min" id = "deatiledSearch"/>
			-
			<input class = "form-control" type = "number" name = "sizeMaxSearch" placeholder = "max" id = "deatiledSearch"/>
			</div>
		</form>
		</div>
		<br>
 	</nav>
	

