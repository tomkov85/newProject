<?php 

	require_once 'RentOnMainView.php';
	$sql = "SELECT * FROM renton.advertisements ";
	$pagemax = "2";
	$order = "beginDate";
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
		$sql = $qo->setDetailedSearchQuery($_GET['prizeMinSearch'], $_GET['prizeMaxSearch'],$_GET['sizeMinSearch'],$_GET['sizeMaxSearch'],$sql);		
	}
	$tableAll = $qo->getTableData($sql);
	$sql = $sql." ORDER BY ";
	
	if(empty($_GET['order'])){
		$order = "beginDate";
	} else {
		$order = $_GET['order'];
	}
	$sql = $sql.$order;
	if(empty($_GET['pagemax'])){
		$pagemax = 2;
	} else {
		$pagemax = $_GET['pagemax'];
	}
	
	if(empty($_GET['page'])){
		$page = 1;
	} else {
		$page = $_GET['page'];
	}
	$pageFirstRecord = ($page-1)*$pagemax;
	$sql = $sql." LIMIT $pageFirstRecord, $pagemax";
	?>
		<form class="form-inline" action="<?php echo $_SERVER['REQUEST_URI']?>" method = "GET">
			Order: <select name = "order" onchange='this.form.submit()'>
						<option value = "Date">Date</option>
						<option value = "Prize">Prize</option>
						<option value = "Size">Size</option>
					</select>
			Limit: <select name = "pagemax" onchange='this.form.submit()'>
						<option value = "50">50</option>
						<option value = "100">100</option>
						<option value = "200">200</option>
					</select>
		</form>
	<?php
	$table = $qo->getTableData($sql);
	$qo->getAdvs($table);

	if(count($tableAll) > $pagemax) {
				$pager = ((count($tableAll) - count($tableAll) % $pagemax) / $pagemax);
				?>
					<ul class="pagination">
					<?php for($i = 1; $i <= $pager; $i++) {?>
					<li><a href="<?php echo $_SERVER['REQUEST_URI'].'&page='.$i?>"><?php echo $i ?></a></li>
					<?php } ?>
				</ul>
				<?php
			}
	
	require_once 'RentOnFooterView.html';
?>