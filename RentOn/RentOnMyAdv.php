<?php

	require_once "RentOnMainView.php";
	$userEmail = $_SESSION['loginName'];
	$userId = $controllerObj->getUserData($userEmail)->id;
	$table = $controllerObj->getUserAdvs($userId);
	?>
	<main>
		<button onclick = "location.href = 'RentOnManageAdv.php?id=0'" class="btn btn-primary" >New Advertisement</button><br><br>
		<?php 
		foreach($table as $row) {
			$deleteId = $row->id * -1;
			?>
			<div>
			<table class = "advTable">
				<tbody>
					<tr class = "advTableCell"><td><h3><?php echo $row->title?></h3></td><td></td></tr>
					<tr><td class = "advTableCell" id = "advImgCell"><img src = "appartmentspics\house.jpg"/></td>
						<td class = "advTableCell"><ul class = "tableList">
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
				</tbody>
			</table>
			<a href = 'RentOnManageAdv.php?id=<?php echo $row->id?>'>Modification</a><a href = 'RentOnManageAdv.php?id=<?php echo $deleteId?>' id = "myAdvDeleteLink">Delete</a>
			</div>
			<br>
		<?php } ?>	
	</main>
	<?php
		require_once 'RentOnFooterView.html';
	?>
	