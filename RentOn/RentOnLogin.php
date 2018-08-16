<?php

	require_once "RentOnMainView.php"

?>

<main>
	<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method = "POST">
    <div class="form-group col-sm-7">
      <label class="control-label col-sm-2" for="email">Email:</label>
	  <div class="col-sm-5">
      <input type="email" class="form-control" name="email" size = "20">
	  </div>
	</div>
	<div class="form-group col-sm-7">
      <label class="control-label col-sm-2" for="pwd">Password:</label>
	  <div class="col-sm-5">
      <input type="password" class="form-control" name="pwd" size = "20"> 
	  </div>
    </div>
    <div class="form-group col-sm-7">
	<div class="col-sm-offset-2 col-sm-5">
    <button type="submit" class="btn btn-primary" name = "loginSubmit">Submit</button>
	</div>
	</div>
	</form>
</main>

<?php
	if(isset($_POST['loginSubmit'])) {
	if(!empty($_POST['email']) & !empty($_POST['pwd'])) {
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
	} else {
		?>
		<div class="col-sm-5 " id = "errorMessage" ><div class = "alert alert-danger" id = "errorMessage"> <strong> Error!</strong> You doesnt fill all the fields! </div></div>
		<?php
	}
	}
	require_once 'RentOnFooterView.html';
?>
