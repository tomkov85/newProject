<?php
	session_start();
	session_destroy();
	header("Location: RentOnHome.php");

?>