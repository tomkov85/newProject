<?php 

	require_once 'RentOnMainView.php';
	$sql = "SELECT * FROM renton.advertisements ";
	
	if(empty($order) & empty($pagemax)) {
	$pagemax = 50;
	$order = "";
	}
	
	if(empty($_GET['page'])) {
		$page = null;
	} else {
		$page = $_GET['page'];
	}
	
	if(!empty($_GET['searchField'])) {
		$city = $_GET['searchField'];
		$sql = $sql."WHERE (city LIKE '%$city%')";
	} 
	
	if(!empty($_GET['prizeMaxSearch']) | !empty($_GET['sizeMaxSearch'])) {
		if(!empty($_GET['searchField'])) {
			$sql = $sql." AND ";
		} else {
			$sql = $sql."WHERE ";
		}
		$sql = $controllerObj->setDetailedSearchQuery($_GET['prizeMinSearch'], $_GET['prizeMaxSearch'],$_GET['sizeMinSearch'],$_GET['sizeMaxSearch'],$sql);		
	}
	$tableAll = count($controllerObj->setSearchData($sql));
	$sql = $sql." ORDER BY ";
	
	if(!empty($_GET['order'])){
		$order = $_GET['order'];
	} else {
		if($order == "") {
		$order = "beginDate";	
		}
	}
	$sql = $sql.$order;

	$sql = $sql.$controllerObj->getLimit($tableAll, $pagemax, $page);

	?>
		<form class="form-inline" action="<?php echo $_SERVER['REQUEST_URI']?>" method = "GET" id = "advListSettingsMenu">
			Order: <select name = "order" onchange ='this.form.submit()'>
						<option value = "beginDate" <?php if($order == "beginDate") {echo "selected";}?>>Date</option>
						<option value = "prize" <?php if($order == "prize") {echo "selected";}?>>Prize</option>
						<option value = "size" <?php if($order == "size") {echo "selected";}?>>Size</option>
					</select>
			Limit: <select name = "pagemax" onchange='this.form.submit()'>
						<option value = "50" <?php if($pagemax == "50") {echo "selected";}?>>50</option>
						<option value = "100" <?php if($pagemax == "100") {echo "selected";}?>>100</option>
						<option value = "200" <?php if($pagemax == "200") {echo "selected";}?>>200</option>
					</select>
		</form>
	<?php
	$table = $controllerObj->setSearchData($sql);;
	$controllerObj->getAdvs($table);

	$controllerObj->getPageLinks($tableAll ,$pageMax);
	
	require_once 'RentOnFooterView.html';
?>