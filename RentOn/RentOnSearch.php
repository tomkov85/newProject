<?php 

	require_once 'RentOnMainView.php';
	$sql = "SELECT * FROM renton.advertisements ";
	
	if(empty($order) & empty($pagemax)) {
	$pagemax = "";
	$order = "";
	}
	
	if(!empty($_GET['searchField'])) {
		$city = $_GET['searchField'];
		$sql = $sql."WHERE (city LIKE '%$city%')";
	} 
	
	if(!empty($_GET['prizeMaxSearch']) | !empty($_GET['sizeMaxSearch'])) {
		if(!empty($_GET['searchField'])) {
			$sql = $sql." AND ";
		} else {
			$sql."WHERE ";
		}
		$sql = $controllerObj->setDetailedSearchQuery($_GET['prizeMinSearch'], $_GET['prizeMaxSearch'],$_GET['sizeMinSearch'],$_GET['sizeMaxSearch'],$sql);		
	}
	$tableAll = $controllerObj->setSearchData($sql);
	$sql = $sql." ORDER BY ";
	
	if(!empty($_GET['order'])){
		$order = $_GET['order'];
	} else {
		if($order == "") {
		$order = "beginDate";	
		}
	}

	$sql = $sql.$order;
	if(empty($_GET['pagemax'])){
		$pagemax = 50;
	} else {
		$pagemax = $_GET['pagemax'];
	}
	
	if(empty($_GET['page'])){
		$pageFirstRecord = 1;
	} else {
		$page = $_GET['page'];
		$pageFirstRecord = ($page - 1)*$pagemax;
	}
	$sql = $sql." LIMIT $pageFirstRecord, $pagemax";

	?>
		<form class="form-inline" action="<?php echo $_SERVER['REQUEST_URI']?>" method = "GET" id = "advListSettingsMenu">
			Order: <select name = "order" onchange ='this.form.submit()'>
						<option value = "beginDate" <?php if($order == "beginDate") {echo "selected";}?>>Date</option>
						<option value = "prize" <?php if($_GET['order'] == "prize") {echo "selected";}?>>Prize</option>
						<option value = "size" <?php if($_GET['order'] == "size") {echo "selected";}?>>Size</option>
					</select>
			Limit: <select name = "pagemax" onchange='this.form.submit()'>
						<option value = "50" <?php if($pagemax == "50") {echo "selected";}?>>50</option>
						<option value = "100" <?php if($_GET['pagemax'] == "100") {echo "selected";}?>>100</option>
						<option value = "200" <?php if($_GET['pagemax'] == "200") {echo "selected";}?>>200</option>
					</select>
		</form>
	<?php
	$table = $controllerObj->setSearchData($sql);;
	$controllerObj->getAdvs($table);

	if(count($tableAll) > $pagemax) {
				$pager = ((count($tableAll) - count($tableAll) % $pagemax) / $pagemax);
				?>
					<ul class="pagination" id = "searchPagination">
					<?php for($i = 1; $i <= $pager; $i++) {?>
					<li><a href="<?php echo $_SERVER['REQUEST_URI'].'&page='.$i?>"><?php echo $i ?></a></li>
					<?php } ?>
				</ul>
				<?php
			}
	
	require_once 'RentOnFooterView.html';
?>