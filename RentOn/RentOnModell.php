<?php

	class ServerConnection {
		private $dns = "mysql:host = 127.0.0.1; dbname = renton";
		private $user = "root";
		private $password = "";
		private $connection;
		private $pager = 2;
		
		public function __construct() {
			try {
				$this->connection = new PDO ($this->dns, $this->user, $this->password);
			} catch (PDOException $e) {
				die($e->getMessage());
			}			
		}
	
	public function getConnection() {
		return $this->connection;
	}
	
	public function getSingleData($sql) {
		$result = $this->connection->query($sql)->fetch(PDO::FETCH_NUM);		
		return $result[0];    
	}
	
	public function getRowData($sql) {
		$result = $this->connection->query($sql)->fetch(PDO::FETCH_OBJ);		
		return $result;    
	}
	
	public function getTableData($sql) {
		$result = $this->connection->query($sql)->fetchAll(PDO::FETCH_OBJ);		
		return $result;    
	}
	
}