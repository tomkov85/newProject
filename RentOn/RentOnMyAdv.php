<?php

	require_once "RentOnMainView.php";
	$userEmail = $_SESSION['loginName'];
	$userId = $qo->getSingleData("SELECT id FROM renton.users WHERE email = '$userEmail'");
	$table = $qo->getTableData("SELECT * FROM renton.advertisements WHERE advUser = $userId ORDER BY beginDate DESC");
	?>
	<main>
		<button onclick = "location.href = 'RentOnManageAdv.php?id=0'" class="btn btn-primary" >New Advertisement</button><br><br>
		<?php 
		foreach($table as $row) {
			$deleteId = $row->id * -1;
			?>
			<div >
			<table>
				<tbody>
					<tr class = "advTable"><td><h3><?php echo $row->title?></h3></td><td></td></tr>
					<tr><td class = "advTable"><img src = "appartmentspics\house.jpg"/></td>
						<td class = "advTable"><ul class = "tableList" style = "list-style:none; padding:0px">
								<?php if($row->rentOrSell) {
									echo "<li> Rent </li>";
								} else {
									echo "<li> Sell </li>";
								} ?>
								<li class = "advTable">City: <?php echo $row->city?><li>
								<li class = "advTable">Size: <?php echo $row->size?> m2<li>
								<li class = "advTable"><h4>Prize: <?php echo $row->prize?> Ft</h4><li>
							</ul>
						</td></tr>
				</tbody>
			</table>
			<a href = 'RentOnManageAdv.php?id=<?php echo $row->id?>'>Modification</a>   <a href = 'RentOnManageAdv.php?id=<?php echo $deleteId?>'>Delete</a>
			</div>
			<br>
		<?php } ?>	
	</main>
