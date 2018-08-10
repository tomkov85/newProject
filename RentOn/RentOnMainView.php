<?php 

	require_once 'RentOnController.php';
	session_start();
	
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
		
			<div class="input-group">
			<input type="text" name = "searchField" class="form-control" size = "30" placeholder="Where do you search house?">
				<div class="input-group-btn">
				
		</div>
		</div>		
			<button class="btn btn-primary" type="submit">Search</button>
			<a data-toggle = "collapse" data-target = "#search" style = "margin-top:30px;">more options</a>
		 
		<ul class="nav navbar-nav navbar-right">
			<?php 
				if(!empty($userName)){
					$newMessageCounter = $qo->getSingleData("SELECT (count(id))newMessageCounter FROM renton.messages WHERE reciever = '$userName' and new = true");
					?>
					<li>
					<div class="dropdown">
						<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style = "margin:7px;"><?php echo $userName ?>
						<span class="caret"></span></button>
						<ul class="dropdown-menu">
							<li><a href = "RentOnMyAdv.php">My Advertisements</a>
							<li><a href = "RentOnMessages.php">Messages<a class = "signedData"><?php echo $newMessageCounter?></a></a>
							<li><a href = "RentOnUserRegistration.php">Data modification</a>
							<li><a href = "RentOnExit.php">Logout</a>
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
			<input class = "form-control" type = "number" name = "sizeMinSearch" placeholder = "min"/>
			-
			<input class = "form-control" type = "number" name = "sizeMaxSearch" placeholder = "max"/>
			</div>
		</form>
		</div>
		<br>
 	</nav>
	

