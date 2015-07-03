
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

	}

	if ( !empty($_POST)) {
		// keep track validation errors
		$titreError = null;
		$descriptionError = null;
		$langError = null;
		
		$config = HTMLPurifier_Config::createDefault();
		//$config->set('HTML', 'Allowed', $value);
		$purifier = new HTMLPurifier($config);
		
		$titre = preg_replace("/<script.*?\/script>/s", "", $_POST['titre']) ? : $_POST['titre'];
		$description = preg_replace("/<script.*?\/script>/s", "", $_POST['description']) ? : $_POST['description'];
		
		// keep track post values
		$titre = htmlspecialchars($titre); //stripslashes(urldecode(preg_replace('/((\%5C0+)|(\%00+))/i', '', urlencode($_POST['titre']))));
		$description = htmlspecialchars($description);//stripslashes(urldecode(preg_replace('/((\%5C0+)|(\%00+))/i', '', urlencode($_POST['description']))));//mysql_real_escape_string();
		$titre = $purifier->purify($titre);
		$description = $purifier->purify($description);
		$lang = $_POST['lang'];
		
		// validate input
		$valid = true;
		if (empty($titre)) {
			$titreError = 'Please enter titre';
			$valid = false;
		}
		
		if (empty($description)) {
			$descriptionError = 'Please enter description ';
			$valid = false;
		} 
		
		if (empty($lang)) {
			$langError = 'Please enter langue';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			
			//add langue
			$sql = $sql = "UPDATE "._DB_PREFIX_."projet_lang  set titre = ?, description = ?   WHERE id = ?";
			
			$q = $pdo->prepare($sql);
			$q->execute(array($titre,$description,$id));
			Database::disconnect();
			header("Location: index.php?page=projet&action=index&pagi=".$pagi."#".$id_projet);
		}
	}
	 else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM "._DB_PREFIX_."projet_lang where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$titre = $data['titre'];
		$description = $data['description'];
		$lang = $data['lang'];
		Database::disconnect();
	}
	
?>
 
 

  <!-- include libraries BS2 -->
 <!--<link href="bootstrap/summereditor/bootstrap-combined.no-icons.min.css" rel="stylesheet"> 
 -->
  <script src="bootstrap/summereditor/bootstrap.min.js"></script> 
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" />

  <!-- include summernote -->
  <link rel="stylesheet" href="bootstrap/summereditor/dist/summernote.css">
  <script type="text/javascript" src="bootstrap/summereditor/dist/summernote.js"></script>

  <script type="text/javascript">
    $(function() {
      $('.summernote').summernote({
        height: 200
      });

      $('form').on('submit', function (e) {
        //e.preventDefault();
       // alert($('.summernote').code());
      });
    });
  </script>


  

    
    				<div id="upload-wrapper" style="width:100%;margin-top: 60px;">
					<div align="">
					
					<h3>Mise à jour description du projet </h3>
		    		
					<form class="form-horizontal" action="index.php?page=projet&action=update_projet_lang&id=<?=$id;?>&id_projet=<?=$id_projet;?>&pagi=<?=$pagi;?>"  method="post"  id="MyUploadForm">
				
  
					   <div class="control-group <?php echo !empty($langError)?'error':'';?>">
					    <label class="control-label">Langue de description</label>
					    <div class="controls">
					      	
								<input name="lang" type="text"  placeholder="" value="<?php echo !empty($lang)?$lang:'';?>" readonly>
								<?php if (!empty($langError)): ?>
					      		<span class="help-inline"><?php echo $langError;?></span>
					      	<?php endif; ?>
					      
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($titreError)?'error':'';?>">
					    <label class="control-label">Titre du projet</label>
					    <div class="controls">
					      	
							<input name="titre" type="text"  placeholder="" value="<?php echo !empty($titre)?$titre:'';?>" >
								<?php if (!empty($titreError)): ?>
					      		<span class="help-inline"><?php echo $titreError;?></span>
					      	<?php endif; ?>
					      
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
					    <label class="control-label">Description</label>
					    <div class="controls">
					      	
							<textarea name="description" class="summernote" style=""><?php echo !empty($description)?$description:'';?></textarea>
								<?php if (!empty($descriptionError)): ?>
					      		<span class="help-inline"><?php echo $descriptionError;?></span>
					      	<?php endif; ?>
					      
					    </div>
					  </div>
					  
					  	  
					   <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  	<a class="btn" href="index.php?page=projet&action=index&pagi=<?=$pagi;?>#<?=$id_projet;?>">Back</a>
						</div>
					   
						
						</form>
						
					  </div>
					    </div>
					 
						
						
					
				
				


	