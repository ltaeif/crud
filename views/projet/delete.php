<?php 
	
	$id = 0;
	
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
		
	$pagi=0;
	if ( !empty($_GET['pagi'])) {
		$pagi = $_REQUEST['pagi'];
		
	}
	
	$id_projet=null;
	if ( !empty($_GET['id_projet'])) {
		$id_projet = $_REQUEST['id_projet'];
	}
	
	
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['id'];
		
		// delete data
		$pdo = Database::connect();
		
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM "._DB_PREFIX_."projet  WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		//delete projet_lang
		$sql = 'DELETE FROM '._DB_PREFIX_.'projet_lang where id_projet = '.$id.'';
		$q = $pdo->prepare($sql);
		$q->execute(array($id));						
		
		
		Database::disconnect();
		header("Location: index.php?page=projet&action=index");
		
	} 
?>



 <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Supprimer Projet</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="index.php?page=projet&action=delete" method="post">
	    			  <input type="hidden" name="id" value="<?php echo $id;?>"/>
					  <p class="alert alert-error" style="width:350px">Etes vous sur ?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Oui</button>
						  <a class="btn" href="index.php?page=projet&action=index&pagi=<?=$pagi;?>#<?=$id_projet?>">Non</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->

