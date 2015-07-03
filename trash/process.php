<?php
require 'config.php';



				$ville = $_GET['ville'];
	
				//echo $ville;
				$pdo = Database::connect();				
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				
				$sql = "INSERT INTO "._DB_PREFIX_."ville (id,fr) values( ?, ?)";
				$q = $pdo->prepare($sql);
				
			
				$q->execute(array( $ville, $ville));
				$id = $pdo->lastInsertId();
			
				

