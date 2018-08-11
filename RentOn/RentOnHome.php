<?php 

	require_once 'RentOnMainView.php';
	$table = $controllerObj->getLastAdvs();
	$controllerObj->getAdvs($table);
	
	require_once 'RentOnFooterView.html';
?>