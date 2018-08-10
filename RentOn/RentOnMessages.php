<?php 

	require_once 'RentOnMainView.php';
	$userName = $_SESSION['loginName'];
	$newMessageCounter = $qo->getSingleData("SELECT count(id) FROM renton.messages WHERE reciever = '$userName' and new = true");
	$recievedMessageCounter = $qo->getSingleData("SELECT count(id) FROM renton.messages WHERE reciever = '$userName'");
	$sentMessageCounter = $qo->getSingleData("SELECT count(id) FROM renton.messages WHERE sender = '$userName'");
	$view = $_GET["view"];
	
		if($view == "recieved") {
		$table = $qo->getTableData("SELECT * FROM renton.messages WHERE reciever = '$userName'");		
		} else if($view == "sent")  {
			$table = $qo->getTableData("SELECT * FROM renton.messages WHERE sender = '$userName'");
		} else {
			$adress = "";
			$title = "";
			$text = "";
			if($view != "new") {
			$row = $qo->getMessage($view);
			$adress = $row->sender;
			$title = $row->messageTitle;
			$text = $row->messageText;
			}
		}
	
?>
<h2>Messages</h2>
<button onclick = "location.href = 'RentOnMessages.php?view=new'" class="btn btn-primary" >New Message</button><br><br>
<aside class = "leftsideMenu">
	<ul>
		<li><a class = "tableList" href = "RentOnMessages.php?view=recieved" style = "list-style:none;">recieved <?php echo $recievedMessageCounter, " New<a class = 'signedData'> $newMessageCounter</a>"?></a></li>
		<li><a class = "tableList" href = "RentOnMessages.php?view=sent" style = "list-style:none;">sent <?php echo $sentMessageCounter?></a></li>
	</ul>	
</aside>	
<div class = "messageMain">	
	<?php 	if($view == "recieved" | $view == "sent") { ?>
			<table>
		    <thead><th>sender</th><th>reciever</th><th>title</th><th>Date</th></thead>
			<tbody>
				<?php foreach ($table as $row) {?>				
					<tr onclick = "location.href = 'RentOnMessages.php?view=<?php  echo $row->id?>'"><td class = "advTable"><?php echo $row->sender ?></td><td class = "advTable"><?php echo $row->reciever ?></td><td class = "advTable"><?php echo $row->messageTitle ?></td><td class = "advTable"><?php echo $row->messageDate ?></td></tr>
				<?php }?>
			</tbody>
		</table>
			
	<?php } else {
		?>
		<form class = "form-horizontal" action = "RentOnMessages.php?view=new" method = "POST">
				<div class = "form-group">
					<label>Adress</label>
						<input type = "text" class = "form-control" name = "newMessageAdress" value = '<?php echo $adress ?>' <?php if($view != "new"){echo  " readonly ";}?> />
				</div>
				<div class = "form-group">
					<label>Title</label>
						<input type = "text" class = "form-control" name = "newMessageTitle" value = '<?php echo $title ?>' <?php if($view != "new"){echo  " readonly ";}?>/>	
				</div>
				<div class = "form-group">
						<textarea name = "newMessageText" <?php if($view != "new"){echo  " readonly ";}?>><?php echo $text?></textarea>				
				</div>
				<button type = "submit" class = "btn btn-primary" name = "newMessageSubmit">Send</button>
		</form></div>
	<?php }
	
	if($_POST) {
		if(!empty($_POST["newMessageAdress"])) {
			$qo->setNewMessage($userName,$_POST["newMessageAdress"], $_POST["newMessageTitle"],$_POST["newMessageText"]);
		}
		
	}
	require_once 'RentOnFooterView.html';
	?>