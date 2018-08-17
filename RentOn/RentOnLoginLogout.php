<?php

	require_once "RentOnMainView.php";
	
	if(!empty($_SESSION["loginName"])) {
		session_destroy();
		header("Location: RentOnHome.php");
	}
?>

<main>
	<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method = "POST">
    <div class="form-group col-sm-7">
      <label class="control-label col-sm-2" for="email">Email:</label>
	  <div class="col-sm-5">
      <input type="email" class="form-control" name="email" required />
	  </div>
	</div>
	<div class="form-group col-sm-7">
      <label class="control-label col-sm-2" for="pwd">Password:</label>
	  <div class="col-sm-5">
      <input type="password" class="form-control" name="pwd"  pattern = "^(?=.*[A-Za-z])(?=.*\d)(?=.*[^<>])[A-Za-z\d]{8,20}$" title = "please give least one number, one letter, minimum 8 characters and, dont use <>" required /> 
	  </div>
    </div>
    <div class="form-group col-sm-7">
	<div class="col-sm-offset-2 col-sm-5">
    <button type="submit" class="btn btn-primary" name = "loginSubmit">Submit</button>
	<a class = "btn btn-primary" href = "RentOnAccountManager.php">Sign Up</a>
	</div>
	</div>
	</form>
	
</main>

<?php
	if(isset($_POST['loginSubmit'])) {
		$email = $_POST['email'];
		$pwd = $_POST['pwd'];
		unset($_POST['submit']);
		if($controllerObj->checkPwd($email, $pwd)) {
			$controllerObj->login($email);
		} else {
			?>
			<div class="col-sm-5" id = "errorMessage" ><div  class = "alert alert-danger" id = "errorMessage"> <strong> Error!</strong> Your email adress or password doesnt match! </div></div>
			<?php
		}	
	}
	require_once 'RentOnFooterView.html';
?>
