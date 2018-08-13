<?php 

	require_once 'RentOnMainView.php';
	$userName = $_SESSION['loginName'];
	$newMessageCounter = $controllerObj->getMessageCounter("reciever = '$userName' and new = true");
	$incomingMessageCounter = $controllerObj->getMessageCounter("reciever = '$userName'");
	$sentMessageCounter = $controllerObj->getMessageCounter("sender = '$userName'");
	$view = $_GET["view"];
	$mrOrw = true;
		if($view == "incoming") {
		$table = $controllerObj->getMessages("reciever = '$userName'");		
		} else if($view == "sent")  {
			$table = $controllerObj->getMessages("sender = '$userName'");
		} else {
			$adress = "";
			$title = "";
			$text = "";
			if($view != "new") {
			$row = $controllerObj->getMessage($view);
			$adress = $row->sender;
			$title = $row->messageTitle;
			$text = $row->messageText;
			}
		}
	
?>
<main>
<h2>Messages</h2>
<button onclick = "location.href = 'RentOnMessages.php?view=new'" class="btn btn-primary" >New Message</button><br><br>
<aside class = "leftsideMenu">
	<ul class = "tableList">
		<li><img src = "icons/glyphicons-123-message-in.png"><a href = "RentOnMessages.php?view=incoming"> incoming <?php echo $incomingMessageCounter, " ,New<span class = 'signedData'><b>$newMessageCounter</b></span>";?></a></li>
		<li><img src = "icons/glyphicons-124-message-out.png"><a href = "RentOnMessages.php?view=sent"> sent <?php echo $sentMessageCounter?></a></li>
	</ul>	
</aside>	
<div class = "messageMain">	
	<?php 	if($view == "incoming" | $view == "sent") { ?>
			<table style ="width:100%">
		    <thead><th>sender</th><th>reciever</th><th>title</th><th>Date</th></thead>
			<tbody>
				<?php foreach ($table as $row) {?>				
					<tr onclick = "location.href = 'RentOnMessages.php?view=<?php  echo $row->id;?>'" <?php if($row->new) {echo "class = 'newMessageBG'";}?> ><td class = "advTable" id = "messageTableSendRecCell"><?php echo $row->sender ?></td><td class = "advTable" id = "messageTableSendRecCell"><?php echo $row->reciever ?></td><td class = "advTable" id = "messageTableTitleCell"><?php echo $row->messageTitle ?></td><td class = "advTable"><?php echo $row->messageDate ?></td></tr>
				<?php }?>
			</tbody>
		</table>
			
	<?php } else {
		?>
		<form class = "form-horizontal" action = "RentOnMessages.php?view=sent" method = "POST" id = "messageForm">
				<div class = "form-group">
					<label>Adress:</label>
					<input type = "email" class = "form-control" name = "newMessageAdress" value = '<?php echo $adress ?>' <?php if($view != "new"){echo  " readonly ";}?> />
				</div>
				<div class = "form-group">
					<label>Title:</label>
					<input type = "text" class = "form-control" name = "newMessageTitle" value = '<?php echo $title ?>' <?php if($view != "new"){echo  " readonly ";}?>/>	
				</div>					
				<div class = "form-group">
					<label>Text:</label>
					<textarea name = "newMessageText" <?php if($view != "new"){echo  " readonly ";}?> id = "messageTextBox"><?php echo $text?></textarea>				
				</div>
				<?php if($view == "new") { 
					$mrOrw = true;
					?>
					<button type = "submit" class = "btn btn-primary" name = "newMessageSubmit">Send</button>
				
				<?php } else { 
					$mrOrw = false;
					?>
					<button type = "submit" class = "btn btn-primary" name = "deleteMessageSubmit">Delete</button>  <button type = "submit" class = "btn btn-primary" name = "">Reply</button>  <button type = "submit" class = "btn btn-primary" name = "">Foward</button>
				<?php } ?>			
		</form>
	<?php } ?>
	</div>
</main>
	<?php
	if($mrOrw) {
	if(isset($_POST['newMessageSubmit'])) {
		unset($_POST['newMessageSubmit']);
		if(!empty($_POST["newMessageAdress"])) {
			$controllerObj->setNewMessage($userName,$_POST["newMessageAdress"], $_POST["newMessageTitle"],$_POST["newMessageText"]);
		} else {
			?>
			<div class="col-sm-offset-1 col-sm-5 "><div  class = "alert alert-danger" id = "loginMessage"> <strong> Error!</strong> You didnt give any email adress! </div></div>
		<?php
		}
	}
	} else if (isset($_POST['deleteMessageSubmit'])) {
		unset($_POST['deleteMessageSubmit']);
		$controllerObj->deleteMessage($view);
	}
	
	require_once 'RentOnFooterView.html';
	?>