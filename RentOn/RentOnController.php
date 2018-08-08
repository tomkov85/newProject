<?php

		class ServerConnection {
		private $dns = "mysql:host = 127.0.0.1; dbname = renton";
		private $user = "root";
		private $password = "";
		private $connection;
		
		public function __construct() {
		try {
			$this->connection = new PDO ($this->dns, $this->user, $this->password);
		} catch (PDOException $e) {
			$e->getMessage();
		}			
	}
	
	public function getSingleData($sql) {
		$result = $this->connection->query($sql)->fetch(PDO::FETCH_NUM);		
		return $result[0];    
	}
	
	public function getRowData($sql) {
		$result = $this->connection->query($sql)->fetch(PDO::FETCH_OBJ);		
		return $result;    
	}
	
	public function getTableData($sql) {
		$result = $this->connection->query($sql)->fetchAll(PDO::FETCH_OBJ);		
		return $result;    
	}
	
	public function checkPwd($email, $pwd) {
		if ($this->getSingleData("SELECT userPassword FROM renton.users WHERE email = '$email'") == $pwd) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function login($name) {
		$_SESSION['loginName'] = $name;
		header("Location: " . $_SERVER['REQUEST_URI']);
		exit();
	}

	public function registNewUser($name, $adress, $phone, $email, $pwd) {
		$this->connection->query("INSERT INTO renton.users VALUES (null, '$name', '$adress',  '$email', '$phone', '$pwd')");
	}
	
	public function manageAdvertisements($id, $title, $type, $city, $size, $heatingType, $prize, $advText, $userId) {
		$type--;
		if($id < 0) {
			$id *= -1;
			$this->connection->query("DELETE FROM renton.advertisements WHERE id = $id");
		} else if ($id == 0) {
			$this->connection->query("INSERT INTO renton.advertisements VALUE (null, '$title', null, '$city', null, $size, $prize, '$heatingType','$advText',$type,$userId,now())");
		} else {
			$this->connection->query("UPDATE renton.advertisements SET title = '$title', rentOrSell = '$type', city = '$city', size = $size, heatingType = '$heatingType', prize = $prize, advertisementText = '$advText' WHERE id = $id"); 
		}
		header('Location:RentOnMyAdv.php');
	}
	
	
	public function getAdvs($table) {
	?>
	<main>
		<?php 
		foreach($table as $row) {
			?>
			<div>
			<table>
				<tbody>
					<tr class = "advTable"><td><h3><?php echo $row->title?></h3></td><td></td></tr>
					<tr><td class = "advTable"><img src = "appartmentspics\house.jpg"/></td>
						<td class = "advTable"><ul class = "tableList">
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
		$row = $this->getRowData("SELECT * FROM renton.advertisements WHERE id = '$id' ORDER BY beginDate DESC");
	?>
	<main>
			<table>
				<tbody>
					<tr><td><h3><?php echo $row->title?></h3></td></tr>
					<tr><td><img src = "appartmentspics\house.jpg"/></td>
						<td><ul style = "list-style:none">
								<?php if($row->rentOrSell) {
									echo "<li> Rent </li>";
								} else {
									echo "<li> Sell </li>";
								} ?>
								<li>City: <?php echo $row->city?><li>
								<li>Size: <?php echo $row->size?> m2<li>
								<li>Heating type: <?php echo $row->heatingType?><li>
								<li><h4>Prize: <?php echo $row->prize?> Ft</h4><li>
							</ul>
						</td></tr>
						<tr><td><p><?php echo $row->advertisementText?></p></td></tr>
						<tr><td><a href = "RentOnMessage.php?number=<?php echo $row->id?>">Send a message</a></td></tr>
				</tbody>
			</table>
			</div>
			<br>
	</main>
	 <?php
	}
	
	public function detailedSearch($prizeMin, $prizeMax, $sizeMin, $sizeMax) {
		$sql = "SELECT * FROM renton.advertisements WHERE";
		
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
		
		$table = $this->getTableData(substr($sql,0,strlen($sql)-3));
		$this->getAdvs($table);
	}
	}
	$qo = new ServerConnection();
	
	
?>