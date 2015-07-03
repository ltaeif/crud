<?php
require 'config.php';



$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
		
if(isset($_GET['publier']) && isset($_GET['id']))
{
				
				//var_dump($_GET);
				if($_GET['publier']==1) $publier=0;
				else $publier=1;
				
		
				$pdo = Database::connect();				
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$sql = "UPDATE "._DB_PREFIX_."projet  set publier = ?   WHERE id = ?";
				
				$q = $pdo->prepare($sql);
					
				$q->execute(array($publier,$id));
				
				Database::disconnect();
				echo json_encode($publier);	
				

}