<?php 
	
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	$id_projet=null;
	if ( !empty($_GET['id_projet'])) {
		$id_projet = $_REQUEST['id_projet'];
	}
	
	$pagi=0;
	if ( !empty($_GET['pagi'])) {
		$pagi = $_REQUEST['pagi'];
		
	}	
	
	if ( null==$id ) {
		header("Location: index.php?page=projet&action=index");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "
		SELECT  pl.*, p.ajoutdate
		FROM "._DB_PREFIX_."projet_lang pl 
		left join "._DB_PREFIX_."projet p ON p.id = pl.id_projet where pl.id = ?";
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
		    			<h3>Description du projet</h3>
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
					    <label class="control-label">Date</label>
					    <div class="controls">
					      	<label class="checkbox">
						     	<?php echo $data['ajoutdate'];?>
						    </label>
					    </div>
					  </div>
					  
					  <div class="control-group">
					    <label class="control-label">titre</label>
					    <div class="controls">
						    <label class="checkbox">
						     	<?php echo $titre;?>
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
						  <a class="btn" href="index.php?page=projet&action=index&pagi=<?=$pagi;?>#<?=$id_projet?>">Back</a>
					   </div>
					
					 
					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>