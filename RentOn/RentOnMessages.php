<?php 

	require_once 'RentOnMainView.php';
	$userName = $_SESSION['loginName'];
	$newMessageCounter = $controllerObj->getMessageCounter("reciever = '$userName' and new = true");
	$incomingMessageCounter = $controllerObj->getMessageCounter("reciever = '$userName'");
	$sentMessageCounter = $controllerObj->getMessageCounter("sender = '$userName'");
	$mrOrw = true;
	
	if(!empty($_GET["view"])) {
		$view = $_GET["view"];
		if($view == "incoming") {
			$table = $controllerObj->getMessages("reciever = '$userName'");		
		} else if($view == "sent")  {
			$table = $controllerObj->getMessages("sender = '$userName'");
		} else {
			$adress = "";
			$title = "";
			$text = "";
			if($view != "new" & $view != "forAdv") {
				$messageId = $_GET['messageId'];
				$row = $controllerObj->getMessage($messageId);
				$adress = $row->sender;
				if($view == "reply") {
					$title = "RE:".$row->messageTitle;
					$text = "(original message: Date: $row->messageDate ".$row->messageText."´)";
				} else if ($view == "foward") {
					$title = "FWD:".$row->messageTitle;
					$text = "(original message: Date: $row->messageDate ".$row->messageText."´)";
				} else {
					$title = $row->messageTitle;
					$text = $row->messageText;
				}
			} else if($view == "forAdv") {
				$id = $_GET['id'];
				$adress = $controllerObj->getUserMailForAdvMessage($id);;
				$title = $controllerObj->getAdvTitleForAdvMessage($id);
			}
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
					<tr onclick = "location.href = 'RentOnMessages.php?view=getOneMessage&messageId=<?php  echo $row->id;?>'" <?php if($row->new) {echo "class = 'newMessageBG'";}?> ><td class = "advTable" id = "messageTableSendRecCell"><?php echo $row->sender ?></td><td class = "advTable" id = "messageTableSendRecCell"><?php echo $row->reciever ?></td><td class = "advTable" id = "messageTableTitleCell"><?php echo $row->messageTitle ?></td><td class = "advTable"><?php echo $row->messageDate ?></td></tr>
				<?php }?>
			</tbody>
		</table>
			
	<?php } else {
		?>
		<form class = "form-horizontal" action = "RentOnMessages.php?view=sent<?php if(!empty($_GET['messageId'])){echo "&messageId=".$messageId;}?>" method = "POST" id = "messageForm">
				<div class = "form-group">
					<label>Adress:</label>
					<input type = "email" class = "form-control" name = "newMessageAdress" value = '<?php echo $adress ?>' <?php if($view == "getOneMessage"){echo  " readonly ";}?> />
				</div>
				<div class = "form-group">
					<label>Title:</label>
					<input type = "text" class = "form-control" name = "newMessageTitle" value = '<?php echo $title ?>' <?php if($view == "getOneMessage"){echo  " readonly ";}?>/>	
				</div>					
				<div class = "form-group">
					<label>Text:</label>
					<textarea name = "newMessageText" <?php if($view== "getOneMessage"){echo  " readonly ";}?> id = "messageTextBox"><?php echo $text?></textarea>				
				</div>
				<?php if($view != "getOneMessage") { 
					$mrOrw = true;
					?>
					<button type = "submit" class = "btn btn-primary" name = "newMessageSubmit">Send</button>
				
				<?php } else { 
					$mrOrw = false;
					?>
					<button type = "submit" class = "btn btn-danger" name = "deleteMessageSubmit">Delete</button> 
				<?php } ?>			
		</form>
		<?php if($view== "getOneMessage") { ?>
		   <button class = "btn btn-primary" id = "replyMessageButton" onclick = "location.href = 'RentOnMessages.php?view=reply&messageId=<?php echo $messageId ?>'">Reply</button>  <button class = "btn btn-primary" name = "" onclick ="location.href = 'RentOnMessages.php?view=foward&messageId=<?php echo $messageId ?>'">Foward</button>
		<?php }
	} ?>
	</div>
</main>
	<?php
	if(isset($_POST['newMessageSubmit'])) {
		unset($_POST['newMessageSubmit']);
		if(!empty($_POST["newMessageAdress"])) {
			$controllerObj->setNewMessage($userName,$_POST["newMessageAdress"], $_POST["newMessageTitle"],$_POST["newMessageText"]);
		} else {
			?>
			<div class="col-sm-5" id = "errorMessage"><div  class = "alert alert-danger" id = "errorMessage"> <strong> Error!</strong> You didnt give any email adress! </div></div>
		<?php
		}
	}
	if(isset($_GET['messageId'])) {
		$messageId = $_GET['messageId'];
	}
	if(isset($_POST['deleteMessageSubmit'])) {	
		unset($_POST['deleteMessageSubmit']);
		$controllerObj->deleteMessage($messageId);
	}
	
	require_once 'RentOnFooterView.html';
	?>