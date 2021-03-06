<?php
	require_once "RentOnMainView.php";
	
	$title = "";
	$type = "";
	$city = "";
	$size = "";
	$heatingSystem = "";
	$prize = "";
	$advText = "";
	$id = 0;
	if(!empty($_GET['id'])) {
	$id = $_GET['id'];
	}
	if($id < 0) {
	  $controllerObj->manageAdvertisements($id, null, null, null, null, null, null, null, null, null, null);
	} else if($id > 0) {
		$row = $controllerObj->getAdvData($id);	
		$title = $row->title;
		if($row->rentOrSell) {
			$type = "rent";
		} else {
			$type = "sell";
		}		
		$city = $row->city;
		$size = $row->size;
		$heatingSystem = $row->heatingSystem;
		$prize = $row->prize;
		$advText = $row->advertisementText;
	}
	?>
	<main>
	<form class="form-horizontal" action="" method = "POST" enctype="multipart/form-data">
	<div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="title">Title:</label>
	  <div class="col-sm-5">
      <input type="text" class="form-control" name="title"  value = "<?php echo $title; ?>" pattern = "[A-Z][^()<>]{3,40}" required />
	  </div>
	</div>
	<div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="type">Rent or Sell:</label>
	  <div class="col-sm-1">
		<input type="radio" class="form-control" name="type" value = "1" checked />Sell
	  </div>
	  <div class="col-sm-1">
		<input type="radio" class="form-control" name="type" value = "2"/>Rent
	  </div>
	</div>
    <div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="city">City:</label>
	  <div class="col-sm-5">
      <input type="text" class="form-control" name="city" value = "<?php echo $city; ?>" pattern = "[A-Z][^()<>]{3,40}" required />
	  </div>
	</div>
	<div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="size">Size:</label>
	  <div class="col-sm-2">
      <input type="number" class="form-control" name="size" value = "<?php echo $size; ?>" required />
	  </div>
	</div>
	<div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="heatingSystem">Heating System:</label>
	  <div class="col-sm-5">
	  <select name = "heatingSystem">
		<option value = "gas">gas</option>
		<option value = "electric">electric</option>
		<option value = "wood">wood</option>
	  </select>
	  </div>
	</div>
	<div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="prize">Prize:</label>
	  <div class="col-sm-3">
      <input type="number" class="form-control" name="prize" value = "<?php echo $prize; ?>" required />
	  </div>
	</div>
	<div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="advText">Adveritsement Text:</label>
	  <div class="col-sm-5">
      <textarea name = "advText" class="col-sm-12"> <?php echo $advText; ?></textarea>
	  </div>
    </div>
	<div class="form-group col-sm-8">
      <label class="control-label col-sm-2" for="imageUpload">Pictures:</label>
	  <div class="col-sm-5">
      <input type="file" class="form-control" name="imageUpload" required />
	  </div>
    </div>
    <div class="form-group col-sm-8">
	<div class="col-sm-offset-2 col-sm-5">
    <button type="submit" class="btn btn-primary" name = "ManageAdvSubmit">Submit</button>
	</div>
	</div>
	</form>
	</main>
	
	<?php
		if(isset($_POST['ManageAdvSubmit'])) {	
				$userEmail = $_SESSION['loginName'];
				$userId = $controllerObj->getUserData($userEmail)->id;
				$controllerObj->manageAdvertisements($id,$_POST['title'],$_POST['type'],$_POST['city'],$_POST['size'],$_POST['heatingSystem'],$_POST['prize'],$_POST['advText'],$userId, $_FILES["imageUpload"]);
	}
	require_once 'RentOnFooterView.html';
?>
