<?php

	require_once "RentOnMainView.php";
	$accountName = "";
	$accountAdress = "";
	$accountPhoneNumber = "";
	$accountEmail = "";
	if(!empty($_SESSION["loginName"])) {
		$accountEmail = $_SESSION["loginName"];
		$accountDatas = $qo->getRowData("SELECT * FROM renton.users WHERE email = '$accountEmail'");
		$accountAdress = $accountDatas->adress;
		$accountPhoneNumber = $accountDatas->phone;
		$accountName = $accountDatas->name;
	}
?>

<main>
	<form class="form-horizontal" action="" method = "POST">
	<div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="name">Name:</label>
	  <div class="col-sm-5">
      <input type="text" class="form-control" name="name" size = "20" value = "<?php echo $accountName; ?>" />
	  </div>
	</div>
    <div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="adress">Adress:</label>
	  <div class="col-sm-5">
      <input type="text" class="form-control" name="adress" size = "20" value = "<?php echo $accountAdress; ?>" />
	  </div>
	</div>
	<div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="phone">Phone number:</label>
	  <div class="col-sm-5">
      <input type="text" class="form-control" name="phoneNumber" size = "20" value = "<?php echo $accountPhoneNumber; ?>" />
	  </div>
	</div>
	<div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="email">Email:</label>
	  <div class="col-sm-5">
      <input type="email" class="form-control" name="email" size = "20" value = "<?php echo $accountEmail; ?>"/>
	  </div>
	</div>
	<div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="pwd">Password:</label>
	  <div class="col-sm-5">
      <input type="password" class="form-control" name="pwd1" size = "20"> 
	  </div>
    </div>
	<div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="pwd">Password again:</label>
	  <div class="col-sm-5">
      <input type="password" class="form-control" name="pwd2" size = "20"> 
	  </div>
    </div>
    <div class="form-group col-sm-8">
	<div class="col-sm-offset-2 col-sm-5">
    <button type="submit" class="btn btn-info" name = "submit">Submit</button>
	</div>
	</div>
	</form>
</main>

<?php
	if(isset($_POST['submit'])){
	if(!empty($_POST['name']) & !empty($_POST['adress']) & !empty($_POST['email']) & !empty($_POST['pwd1']) & !empty($_POST['pwd2'])) {
		$name = $_POST['name'];
		$adress = $_POST['adress'];
		$email = $_POST['email'];
		$pwd1 = $_POST['pwd1'];
		$pwd2 = $_POST['pwd2'];
		unset($_POST['submit']);
		if(empty($_POST['phoneNumber'])) {
			$phone = null;
		} else {
			$phone = $_POST['phoneNumber'];
		}
		
		if ($pwd1 == $pwd2) {
		if($qo->checkPwd($email, $pwd1) != null) {
			$qo->registNewUser($name, $adress, $phone, $email, $pwd1);
		} else {
			?>
			<div class="col-sm-offset-1 col-sm-5 "><div  class = "alert alert-danger" id = "loginMessage"> <strong> Error!</strong> There is a registration for this email! </div></div>
			<?php
		}
		} else {
			?>
			<div class="col-sm-offset-1 col-sm-5 "><div  class = "alert alert-danger" id = "loginMessage"> <strong> Error!</strong> Your password doesnt match! </div></div>
			<?php
		}
	} else {
		?>
		<div class="col-sm-offset-1 col-sm-5 "><div class = "alert alert-danger" id = "loginMessage"> <strong> Error!</strong> You doesnt fill all the fields! </div></div>
		<?php
	}
	}
?>