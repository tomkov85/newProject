<?php 

	require_once 'RentOnMainView.php';
	
	if(empty($_SESSION["loginName"])) {
		$table = $controllerObj->getLastAdvs();
		$controllerObj->getAdvs($table);
	} else {
		$userEmail = $_SESSION['loginName'];
		$userId = $controllerObj->getUserData($userEmail)->id;
		$table = $controllerObj->getUserAdvs($userId,"");
		$tableAll = count($table);
		
		if(empty($_GET['page'])) {
			$page = null;
		} else {
			$page = $_GET['page'];
		}
		
		$limitQuery = $controllerObj->getLimit($tableAll, 20, $page);
		$table = $controllerObj->getUserAdvs($userId, $limitQuery);
		
		?>
		<main>
			<button onclick = "location.href = 'RentOnAdvManager.php?id=0'" class="btn btn-primary" >New Advertisement</button><br><br>
			<?php 
			foreach($table as $row) {
				$deleteId = $row->id * -1;
				
				$controllerObj->startAdvTable($row); ?>
				
							</td></tr>
					</tbody>
				</table>
				<a href = 'RentOnAdvManager.php?id=<?php echo $row->id?>'>Modification</a><a href = 'RentOnAdvManager.php?id=<?php echo $deleteId?>' id = "myAdvDeleteLink">Delete</a>
				</div>
				<br>
			<?php } ?>	
		</main>
		<?php
	}
	$controllerObj->getPageLinks($tableAll ,20);
	require_once 'RentOnFooterView.html';
?>