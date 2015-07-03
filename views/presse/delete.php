<?php 
	
	$id = 0;
	
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	
	$pagi=0;
	if ( !empty($_GET['pagi'])) {
		$pagi = $_REQUEST['pagi'];
		
	}
	
	$id_presse=null;
	if ( !empty($_GET['id_presse'])) {
		$id_presse = $_REQUEST['id_presse'];
	}
	
	
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['id'];
		
		// delete data
		$pdo = Database::connect();
		
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM "._DB_PREFIX_."presse  WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		//delete presse_lang
		$sql = 'DELETE FROM '._DB_PREFIX_.'presse_lang where id_presse = '.$id.'';
		$q = $pdo->prepare($sql);
		$q->execute(array($id));						
		
		
		Database::disconnect();
		header("Location: index.php?page=presse&action=index");
		
	} 
?>



 <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Supprimer presse</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="index.php?page=presse&action=delete" method="post">
	    			  <input type="hidden" name="id" value="<?php echo $id;?>"/>
					  <p class="alert alert-error" style="width:350px">Etes vous sur ?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Oui</button>
						  <a class="btn" href="index.php?page=presse&action=index&pagi=<?=$pagi;?>#<?=$id_presse?>">Non</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->

