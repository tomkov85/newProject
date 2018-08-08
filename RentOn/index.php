<?php 

	require_once 'RentOnMainView.php';
	$qo->getTable("SELECT * FROM renton.advertisements ORDER BY beginDate DESC limit 5");
?>
	
	