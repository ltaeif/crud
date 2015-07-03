<?php 
	
	$id = 0;
	
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['id'];
		
		// delete data
		$pdo = Database::connect();
		
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE  "._DB_PREFIX_."projet  set publier = ".$pub." WHERE id = ?";
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
		    		
	    			<form class="form-horizontal" action="index.php?page=projet&action=publier" method="post">
	    			  <input type="hidden" name="id" value="<?php echo $id;?>"/>
					  <p class="alert alert-error" style="width:350px">Publier cet article ?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-info">Oui</button>
						  <a class="btn" href="index.php?page=projet&action=index">Non</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->

