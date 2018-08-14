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
			
			$controllerObj->startAdvTable($row); ?>
			
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
	