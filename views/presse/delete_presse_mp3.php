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
	if ( !empty($_GET['id'])) {
		$id_presse = $_REQUEST['id'];
	}
	
	
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['id'];

					try { 
							$pdo = Database::connect();

						//select the last image name
							$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$sql = "SELECT * FROM "._DB_PREFIX_."presse  where id = ?";
							$q = $pdo->prepare($sql);

						try { 
							$pdo->beginTransaction(); 
							$q->execute(array($id));
							$data = $q->fetch(PDO::FETCH_ASSOC);
							$mp3 = $data['mp3'];
							$pdo->commit(); 
							
							//delete from folder
						 	 if(file_exists(_ASS_UPLOAD_SON_PRESSE_DIR_."$mp3")) 
								 {
								$result =  @unlink(_ASS_UPLOAD_SON_PRESSE_DIR_."$mp3"); 				
								 
								 }
							 
							 //Mise à jour final
							 
							 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							 $sql = "Update  "._DB_PREFIX_."presse set mp3=NULL  WHERE id = ?";
							 $q = $pdo->prepare($sql);
							 $q->execute(array($id));
				
							
						} catch(PDOExecption $e) { 
							$pdo->rollback(); 
							print "Error!: " . $e->getMessage() . "</br>"; 
						} 
						
								Database::disconnect();
						
					} catch( PDOExecption $e ) { 
						print "Error!: " . $e->getMessage() . "</br>"; 
					} 
		
		
		
		
		
		
		Database::disconnect();
		
		header("Location: index.php?page=presse&action=index&id=".$id."&pagi=".$pagi.'#'.$id);
		
	} 
?>



 <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Supprimer MP3 Presse</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="index.php?page=presse&action=delete_presse_mp3" method="post">
	    			  <input type="hidden" name="id" value="<?php echo $id;?>"/>
					  <p class="alert alert-error" style="width:350px">Etes vous sur ?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Oui</button>
						  <a class="btn" href="index.php?page=presse&action=index&pagi=<?=$pagi;?>#<?=$id_presse?>">Non</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->

