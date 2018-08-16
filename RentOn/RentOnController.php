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
		header("location: RentOnMyAdv.php");
	}
	/*
	public function setCookies($email, $pwd) {
		$cookie_name = '$email';
		$cookie_value = '$pwd';
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); 
	}*/
	
	public function registNewUser($name, $adress, $phone, $email, $pwd) {
		$this->rmObj->getConnection()->query("INSERT INTO renton.users VALUES (null, '$name', '$adress',  '$email', '$phone', '$pwd')");
		header('location:RentOnLogin.php');
	}
	
	public function updateUser($name, $adress, $phone, $email, $pwd) {
		$this->rmObj->getConnection()->query("UPDATE renton.users SET name='$name' adress='$adress' email= $email' phone='$phone' userPassword='$pwd' WHERE email='$email'");
	}
	
	public function getUserData($accountEmail) {
		return $this->rmObj->getRowData("SELECT * FROM renton.users WHERE email = '$accountEmail'");
	}
	
	public function getUserAdvs($userId) {
		return $this->rmObj->getTableData("SELECT * FROM renton.advertisements WHERE advUser = $userId ORDER BY beginDate DESC");
	}
	
	public function manageAdvertisements($id, $title, $type, $city, $size, $heatingType, $prize, $advText, $userId, $fileData) {
		if($id < 0) {
			$userId = $id * (-1);
		}
		if($fileData != null){
		$fileName = basename($fileData["name"]);
		} else {
			$fileName = $this->getAdvData($userId)->advImage;
		}
		$type--;
		if($id < 0) {
			$filepath = "appartmentspics/".$fileName;
			unlink($filepath);
			$this->rmObj->getConnection()->query("DELETE FROM renton.advertisements WHERE id = $userId");
			header('location:RentOnMyAdv.php');
		} else if ($id == 0) {
			$lastId = $this->rmObj->getSingleData("SELECT id FROM renton.advertisements ORDER BY id DESC LIMIT 1") + 1;
			$allowed = $this->checkUploadFile($fileData, $lastId);
			if($allowed) {
			$fileName = basename($lastId.".".strtolower(pathinfo($fileData['name'],PATHINFO_EXTENSION)));
			$this->rmObj->getConnection()->query("INSERT INTO renton.advertisements VALUE (null, '$title', '$fileName', null, '$city', null, $size, $prize, '$heatingType','$advText',$type,$userId,now())");
				?>
				<div class="col-sm-5" id = "errorMessage"><div  class = "alert alert-success" id = "errorMessage"> <strong> Success!</strong> You have a new advertisement! </div></div>
				<?php
			}
		} else {
			$allowed = $this->checkUploadFile($fileData,$id);
			if($allowed) {
			$this->rmObj->getConnection()->query("UPDATE renton.advertisements SET title = '$title', advImage = '$fileName', rentOrSell = '$type', city = '$city', size = $size, heatingType = '$heatingType', prize = $prize, advertisementText = '$advText' WHERE id = $userId"); 		
			}
		}
	}
	
	public function checkUploadFile($fileData, $lastId ) {
		$target_dir = "C:/xampp/htdocs/RentOn/appartmentspics/";
		$target_file = $target_dir . basename($lastId.".".strtolower(pathinfo($fileData['name'],PATHINFO_EXTENSION)));
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		
		$check = getimagesize($fileData["tmp_name"]);
		if($check !== false) {
			//echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {?>
			<div class="col-sm-offset-1 col-sm-5 "><div  class = "alert alert-danger" id = "loginMessage"> <strong> Error!</strong> The file is not an image! </div></div>
			<?php
			$uploadOk = 0;
		}	

		if ($fileData["size"] > 5000000) {?>
				<div class="col-sm-offset-1 col-sm-5 "><div  class = "alert alert-danger" id = "loginMessage"> <strong> Error!</strong> The file is too large, the size is have to be under 5MB! </div></div>
				<?php
			$uploadOk = 0;
		}

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {?>
				<div class="col-sm-offset-1 col-sm-5 "><div  class = "alert alert-danger" id = "loginMessage"> <strong> Error!</strong> Only JPG, JPEG, PNG & GIF files are allowed. </div></div>
				<?php
			$uploadOk = 0;
		}

		if ($uploadOk == 0) {?>
				<div class="col-sm-offset-1 col-sm-5 "><div  class = "alert alert-danger" id = "loginMessage"> <strong> Error!</strong> Your file was not uploaded. </div></div>
				<?php
		} else {
			if (move_uploaded_file($fileData["tmp_name"], $target_file)) {
				//echo "The file ". basename($lastId.".".strtolower(pathinfo($fileData['name'],PATHINFO_EXTENSION))). " has been uploaded.";
			} else {?>
				<div class="col-sm-offset-1 col-sm-5 "><div  class = "alert alert-danger" id = "loginMessage"> <strong> Error!</strong> There was an error uploading your file.</div></div>
				<?php
			}
		}
		
		return $uploadOk;
	}
	
	public function getAdvData($id) {
		return $this->rmObj->getRowData("SELECT * FROM renton.advertisements WHERE id = $id");
	} 
	
	public function getAdvs($table) {
	?>
	<main>
		<?php 
		foreach($table as $row) {
			$this->startAdvTable($row);
			?>
				
						<tr><td><a href = "RentOnAdvDetails.php?number=<?php echo $row->id?>">more</a></td></tr>
				</tbody>
			</table>
			</div>
			<br>
		<?php } ?>
	</main>
	 <?php
	}

	public function startAdvTable($row) {
		?>
		<div>
			<table class = "advTable">
				<tbody>
					<tr class = "advTableCell"><td  colspan="2"><h3><?php echo $row->title?></h3></td></tr>
					<tr><td class = "advTableCell" id = "advImgCell"><img src = "<?php echo 'appartmentspics/'.$row->advImage ?>" id = "advImage"/></td>
						<td class = "advTableCell"><ul class = "tableList">
								<li class = "advTableListElement">
								<?php if($row->rentOrSell) {
									echo " Rent ";
								} else {
									echo "Sell ";
								} ?>
								</li>
								<li class = "advTableListElement"> City: <?php echo $row->city?><li>
								<li class = "advTableListElement"> Size: <?php echo $row->size?> m2<li>
								<li class = "advTableListElement"> Heating System: <?php echo $row->heatingSystem?><li>
								<li><h4> Prize: <?php echo $row->prize?> Ft</h4><li>
							</ul>
						</td></tr>
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
		header('location:RentOnMessages.php?view=sent');
	}
	
	public function getMessage($view) {
		$this->rmObj->getConnection()->query("UPDATE renton.messages SET new = 0 WHERE id = $view");
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
	
	public function deleteMessage($id) {
		$this->rmObj->getConnection()->query("DELETE FROM renton.messages WHERE id = '$id'");
		header('location:RentOnMessages.php?view=sent');
	}
	
	public function getAdvTitleForAdvMessage($id) {
		$actualSql = "SELECT title FROM renton.advertisements WHERE id = '$id'";
		return $this->rmObj->getSingleData($actualSql);
	}
	
	public function getUserMailForAdvMessage($id) {
		$userId = $this->rmObj->getSingleData("SELECT advUser FROM renton.advertisements WHERE id = '$id'");
		$actualSql = "SELECT email FROM renton.users WHERE id = '$userId'";
		return $this->rmObj->getSingleData($actualSql);
	}
	}
?>