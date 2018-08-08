<?php 

	require_once 'RentOnMainView.php';
	if(!empty($_GET['searchField'])) {
		$city = $_GET['searchField'];
		$table = $qo->getTableData("SELECT * FROM renton.advertisements WHERE city LIKE '%$city%' ORDER BY beginDate DESC");
		$qo->getAdvs($table);
	}
	
	if(!empty($_GET['prizeMaxSearch']) | !empty($_GET['sizeMaxSearch'])) {
		$qo->detailedSearch($_GET['prizeMinSearch'], $_GET['prizeMaxSearch'],$_GET['sizeMinSearch'],$_GET['sizeMaxSearch']);	
		
	}
	
?>