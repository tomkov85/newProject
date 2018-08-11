<?php

	require_once "RentOnMainView.php";

	$controllerObj->getAdv($_GET['number']);
	
	require_once 'RentOnFooterView.html';
?>