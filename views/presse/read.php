<?php 
	
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	$id_presse=null;
	if ( !empty($_GET['id_presse'])) {
		$id_presse = $_REQUEST['id_presse'];
	}
		
	$pagi=0;
	if ( !empty($_GET['pagi'])) {
		$pagi = $_REQUEST['pagi'];
		
	}	
	
	if ( null==$id ) {
		header("Location: index.php?page=presse&action=index");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM "._DB_PREFIX_."presse_lang where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$titre = htmlspecialchars_decode($data['titre']);
		$description = htmlspecialchars_decode($data['description']);
		$lang = $data['lang'];
		Database::disconnect();
	}
?>

    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Description du presse</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Langue</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['lang'];?>
						    </label>
					    </div>
					  </div>
					  
					  <div class="control-group">
					    <label class="control-label">titre</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $titre; ?>
						    </label>
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Description</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $description;?>
						    </label>
					    </div>
					  </div>
					
					    <div class="form-actions">
						  <a class="btn" href="index.php?page=presse&action=index&pagi=<?=$pagi;?>#<?=$id_presse?>">Back</a>
					   </div>
					
					 
					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>