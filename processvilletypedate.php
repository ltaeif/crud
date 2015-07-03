<?php
require 'config.php';



$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
		
	if(isset($_GET['ville']) || isset($_GET['type']) || isset($_GET['date'])){
				
				//var_dump($_GET);
				$ville = $_GET['ville'];
				$type = $_GET['type'];
				$date = $_GET['date'];
				
				$pdo = Database::connect();				
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$sql = "UPDATE "._DB_PREFIX_."projet  set type = ? , ajoutdate = ?   WHERE id = ?";
				
				$q = $pdo->prepare($sql);
					
				$q->execute(array( $type,$date,$id));
					
					
				//update ville  lang projet
					
					
				$sql = "UPDATE "._DB_PREFIX_."projet_lang  set  ville = ?   WHERE id_projet = ?";
				$q = $pdo->prepare($sql);
				
				$q->execute(array($ville,$id));
				
		
					
			
					
				
				Database::disconnect();

echo json_encode('good');			;
}