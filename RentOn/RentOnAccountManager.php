<?php

	require_once "RentOnMainView.php";
	$accountName = "";
	$accountAddress = "";
	$accountPhoneNumber = "";
	$accountEmail = "";
	if(!empty($_SESSION["loginName"])) {
		$accountEmail = $_SESSION["loginName"];
		$accountDatas = $controllerObj->getUserData($accountEmail);
		$accountAddress = $accountDatas->address;
		$accountPhoneNumber = $accountDatas->phone;
		$accountName = $accountDatas->name;
	}
?>

<main>
	<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method = "POST">
	<div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="name">Name:</label>
	  <div class="col-sm-5">
      <input type="text" class="form-control" name="name" value = "<?php echo $accountName; ?>" pattern = "[A-Z][^()<>]{3,40}" title = "please give normal name" required />
	  </div>
	</div>
    <div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="address">Address:</label>
	  <div class="col-sm-5">
      <input type="text" class="form-control" name="address" value = "<?php echo $accountAddress; ?>" pattern = "[A-Z][^()<>]{3,40}" title = "please give normal adress" />
	  </div>
	</div>
	<div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="phone">Phone number:</label>
	  <div class="col-sm-5">
      <input type="tel" class="form-control" name="phoneNumber" value = "<?php echo $accountPhoneNumber; ?>"/>
	  </div>
	</div>
	<div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="email">Email:</label>
	  <div class="col-sm-5">
      <input type="email" class="form-control" name="email" value = "<?php echo $accountEmail; ?>" required />
	  </div>
	</div>
	<div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="pwd">Password:</label>
	  <div class="col-sm-5">
      <input type="password" class="form-control" name="pwd1" pattern = "^(?=.*[A-Za-z])(?=.*\d)(?=.*[^<>])[A-Za-z\d]{8,20}$" title = "please give least one number, one letter, minimum 8 characters and, dont use <>" required /> 
	  </div>
    </div>
	<div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="pwd">Password again:</label>
	  <div class="col-sm-5">
      <input type="password" class="form-control" name="pwd2" pattern = "^(?=.*[A-Za-z])(?=.*\d)(?=.*[^<>])[A-Za-z\d]{8,20}$" title = "please give least one number, one letter, minimum 8 characters and, dont use <>" required /> 
	  </div>
    </div>
    <div class="form-group col-sm-8">
	<div class="col-sm-offset-2 col-sm-5">
    <button type="submit" class="btn btn-primary" name = "registSubmit">Submit</button>
	</div>
	</div>
	</form>
</main>

<?php

	if(isset($_POST['registSubmit'])){
		$name = $_POST['name'];
		$address = $_POST['address'];
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
		if($controllerObj->checkPwd($email, $pwd1) == null) {
			$controllerObj->registNewUser($name, $address, $phone, $email, $pwd1);
		} else {
			if(!empty($_SESSION["loginName"])) {
				$controllerObj->updateUser($name, $address, $phone, $email, $pwd1);
			} else {
			?>
			<div class="col-sm-5" id = "errorMessage"><div  class = "alert alert-danger" id = "errorMessage"> <strong> Error!</strong> There is a registration for this email! </div></div>
			<?php
			}
		}
		} else {
			?>
			<div class="col-sm-5" id = "errorMessage"><div  class = "alert alert-danger" id = "errorMessage"> <strong> Error!</strong> Your password doesnt match! </div></div>
			<?php
		}
	}
	require_once 'RentOnFooterView.html';
?>