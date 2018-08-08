<?php 

	require_once 'RentOnMainView.php';
	$table = $qo->getTableData("SELECT * FROM renton.advertisements ORDER BY beginDate DESC limit 5");
	$qo->getAdvs($table);
?>