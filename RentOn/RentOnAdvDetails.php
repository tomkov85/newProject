<?php

	require_once "RentOnMainView.php";

	$id = $_GET['number'];
	?>
	<main>
		<?php 
		$row = $controllerObj->getAdvData($id);
		$controllerObj->startAdvTable($row);
	?>
	
						<tr class = "advTableCell"><td colspan="2"><p><?php echo $row->advertisementText?></p></td></tr>
						<?php if(!empty($_SESSION['loginName'])) {
							?>		
							<tr><td><a href = "RentOnMessages.php?view=forAdv&id=<?php echo $row->id?>">Send a message</a></td></tr>
						<?php }else{ ?>
							<tr><td colspan="2"><a>to send a message, please <strong><a href="RentOnLoginLogout.php"> login</a></strong><a> or </a><strong><a href="RentOnAccountManager.php"> sign up</a></strong></a></td></tr>
							<?php } ?>
				</tbody>
			</table>
			</div>
			<br>
	</main>
	 <?php
	
	require_once 'RentOnFooterView.html';
?>