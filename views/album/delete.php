<?php 
	
	$id = 0;
	
	if ( !empty($_GET['name'])) {
		$name = $_REQUEST['name'];
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$name = $_POST['name'];
		
		
		// delete data
		$pdo = Database::connect();
		
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM "._DB_PREFIX_."album  WHERE image = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($name));
		Database::disconnect();
		header("Location: index.php?page=projet&action=index");
		
		
		  if(file_exists(_ASS_ALBUM_UPLOAD_DIR_."$name")) 
					 {
					
					 $result =  @unlink(_ASS_ALBUM_UPLOAD_DIR_."$name"); 				
					 $result =  @unlink( _ASS_ALBUM_UPLOAD_DIR_.'thumbs/'.$thumb_prefix."$name"); 	

					 }
					 
					 
		header("Location: index.php?page=album&action=index");
		
	} 
?>



    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Supprimer Image</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="index.php?page=album&action=delete" method="post">
	    			  <input type="hidden" name="name" value="<?php echo $name;?>"/>
					  <p class="alert alert-error" style="width:350px">Etes vous sur ?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Oui</button>
						  <a class="btn" href="index.php?page=album&action=index">Non</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
