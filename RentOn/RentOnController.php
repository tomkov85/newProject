<?php

	include 'RentOnModell.php';
	
	class Controller {
		private $rmObj;
		
		public function __construct() {
			$this->rmObj = new ServerConnection();			
		}
	
	public function getLastAdvs() {
		return $this->rmObj->getTableData("SELECT * FROM renton.advertisements ORDER BY beginDate DESC limit 5");
	}
		
	public function checkPwd($email, $pwd) {
		if ($this->rmObj->getSingleData("SELECT userPassword FROM renton.users WHERE email = '$email'") == $pwd) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function login($name) {
		$_SESSION['loginName'] = $name;
		header("location: " . $_SERVER['REQUEST_URI']);
		exit();
	}

	public function registNewUser($name, $adress, $phone, $email, $pwd) {
		$this->rmObj->getConnection()->query("INSERT INTO renton.users VALUES (null, '$name', '$adress',  '$email', '$phone', '$pwd')");
	}
	
	public function getUserData($accountEmail) {
		return $this->rmObj->getRowData("SELECT * FROM renton.users WHERE email = '$accountEmail'");
	}
	
	public function getUserAdvs($userId) {
		return $this->rmObj->getTableData("SELECT * FROM renton.advertisements WHERE advUser = $userId ORDER BY beginDate DESC");
	}
	
	public function manageAdvertisements($id, $title, $type, $city, $size, $heatingType, $prize, $advText, $userId) {
		$type--;
		if($id < 0) {
			$id *= -1;
			$this->rmObj->getConnection()->query("DELETE FROM renton.advertisements WHERE id = $id");
		} else if ($id == 0) {
			$this->rmObj->getConnection()->query("INSERT INTO renton.advertisements VALUE (null, '$title', null, '$city', null, $size, $prize, '$heatingType','$advText',$type,$userId,now())");
		} else {
			$this->rmObj->getConnection()->query("UPDATE renton.advertisements SET title = '$title', rentOrSell = '$type', city = '$city', size = $size, heatingType = '$heatingType', prize = $prize, advertisementText = '$advText' WHERE id = $id"); 
		}
		header('Location:RentOnMyAdv.php');
	}
	
	public function getAdvData($id) {
		return $this->rmObj->getRowData("SELECT * FROM renton.advertisements WHERE id = '$id'");
	} 
	
	public function getAdvs($table) {
	?>
	<main>
		<?php 
		foreach($table as $row) {
			?>
			<div>
			<table class = "advTable">
				<tbody>
					<tr class = "advTableCell"><td><h3><?php echo $row->title?></h3></td><td></td></tr>
					<tr><td class = "advTableCell" id = "advImgCell"><img src = "appartmentspics\house.jpg"/></td>
						<td class = "advTableCell"><ul class = "tableList">
								<li class = "advTableListElement">
								<?php if($row->rentOrSell) {
									echo " Rent ";
								} else {
									echo "Sell ";
								} ?>
								</li>
								<li class = "advTableListElement">City: <?php echo $row->city?><li>
								<li class = "advTableListElement">Size: <?php echo $row->size?> m2<li>
								<li class = "advTableListElement"><h4>Prize: <?php echo $row->prize?> Ft</h4><li>
							</ul>
						</td></tr>
						<tr><td><a href = "RentOnAdvDetails.php?number=<?php echo $row->id?>">more</a></td></tr>
				</tbody>
			</table>
			</div>
			<br>
		<?php } ?>
	</main>
	 <?php
	}
	public function getAdv($id) {
		$row = $this->getAdvData($id);
	?>
	<main>
			<table class = "advTable">
				<tbody>
					<tr class = "advTableCell"><td><h3><?php echo $row->title?></h3></td><td></td></tr>
					<tr><td class = "advTableCell" id = "advImgCell"><img src = "appartmentspics\house.jpg"/></td>
						<td class = "advTableCell"><ul class = "tableList">
								<li class = "advTableListElement">
								<?php if($row->rentOrSell) {
									echo " Rent ";
								} else {
									echo "Sell ";
								} ?>
								</li>
								<li class = "advTableListElement">City: <?php echo $row->city?><li>
								<li class = "advTableListElement">Size: <?php echo $row->size?> m2<li>
								<li class = "advTableListElement"><h4>Prize: <?php echo $row->prize?> Ft</h4><li>
							</ul>
						</td></tr>
						<tr class = "advTableCell"><td ><p><?php echo $row->advertisementText?></p></td></tr>
						<tr><td><a href = "RentOnMessage.php?number=<?php echo $row->id?>">Send a message</a></td></tr>
				</tbody>
			</table>
			</div>
			<br>
	</main>
	 <?php
	}
	
	public function setSearchData($sql) {
		return $this->rmObj->getTableData($sql);
	}
	
	public function setDetailedSearchQuery($prizeMin, $prizeMax, $sizeMin, $sizeMax, $sql) {
		if($prizeMax != null) {
			if($prizeMin != null) {
				$prizeMin = 0;
			}
			$sql = $sql."(prize BETWEEN '$prizeMin' AND '$prizeMax') AND";
		}
		
		if($sizeMax != null) {
			if($sizeMin != null) {
				$sizeMin = 0;
			}
			$sql = $sql."(size BETWEEN '$sizeMin' AND '$sizeMax') AND";
		}
		
		return substr($sql,0,strlen($sql)-3);
	}
	
	public function setNewMessage($sender,$adress,$title,$text) {
		$this->rmObj->getConnection()->query("INSERT INTO renton.messages VALUES (null, '$sender', '$adress',  '$title', '$text',1, now())");
	}
	
	public function getMessage($view) {
		$this->rmObj->getConnection()->query("UPDATE renton.message SET new = false");
		return $this->rmObj->getRowData("SELECT * FROM renton.messages WHERE id = $view");
	}
	
	public function getMessages($sql) {
		$actualSql = "SELECT * FROM renton.messages WHERE ".$sql;
		return $this->rmObj->getTableData($actualSql);
	}
	
	public function getMessageCounter($sql) {
		$actualSql = "SELECT (count(id))newMessageCounter FROM renton.messages WHERE ".$sql;
		return $this->rmObj->getSingleData($actualSql);
	}
	}
?>