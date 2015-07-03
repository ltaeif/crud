
<?php 
	
	
$typeError = null;
		$image_fileError = null;
		$villeError = null;
	
	
	$pagi=0;
	if ( !empty($_GET['pagi'])) {
		$pagi = $_REQUEST['pagi'];
		
	}
	
	
	/*if ( !empty($_POST)) {
		// keep track validation errors
		$titreError = null;
		$descriptionError = null;
		$langError = null;
		
		// keep track post values
		$titre = $_POST['titre'];
		$description = $_POST['description'];
		$lang = $_POST['lang'];
		
		// validate input
		$valid = true;
		if (empty($titre)) {
			$titreError = 'Please enter titre';
			$valid = false;
		}
		
		if (empty($description)) {
			$descriptionError = 'Please enter description Address';
			$valid = false;
		} else if ( !filter_var($description,FILTER_VALIDATE_description) ) {
			$descriptionError = 'Please enter a valid description Address';
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
			
			//add unique projet
			
			
			//add langue
			$sql = "INSERT INTO projet_lang (titre,description,lang) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array('NOW()'));
			Database::disconnect();
			header("Location: index.php");
		}
	}
	*/
?>

<script type="text/javascript">
$(document).ready(function() { 
	var options = { 
			target: '#output',   // target element(s) to be updated with server response 
			beforeSubmit: beforeSubmit,  // pre-submit callback 
			success: afterSuccess,  // post-submit callback 
			resetForm: true        // reset the form after successful submit 
		}; 
		
	 $('#MyUploadForm').submit(function() { 
			$(this).ajaxSubmit(options);  			
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}); 
}); 

function afterSuccess()
{
	$('#submit-btn').show(); //hide submit button
	$('#loading-img').hide(); //hide submit button
	$('#alert').html('<p class="alert alert-success" style="width:350px">Ajout éffectué</p>');

}

//function to check file size before uploading.
function beforeSubmit(){

	$('#alert').html('');
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( !$('#imageInput').val() || !$('#type').val() || !$('#ville').val() ) //check empty input filed
		{
			$("#output").html("Remplir les champs?");
			return false
		}
		
		var fsize = $('#imageInput')[0].files[0].size; //get file size
		var ftype = $('#imageInput')[0].files[0].type; // get file type
		

		//allow only valid image file types 
		switch(ftype)
        {
            case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
                break;
            default:
                $("#output").html("<b>"+ftype+"</b> Unsupported file type!");
				return false
        }
		
		//Allowed file size is less than 1 MB (1048576)
		if(fsize>1048576) 
		{
			$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
			return false
		}
				
		$('#submit-btn').hide(); //hide submit button
		$('#loading-img').show(); //hide submit button
		$("#output").html("");  
	}
	else
	{
		//Output error to older browsers that do not support HTML5 File API
		$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

</script>

 
  <div class="form-actions">
	<a class="btn" href="index.php?page=projet&action=index&pagi=<?=$pagi;?>">Back</a>
  </div>
  
	
    				<div id="upload-wrapper" style="width:100%">
					<div align="center">
					
		    			<h3>Créer un projet</h3>
		    		<div id="alert">
		  
					</div>
					<form class="form-horizontal" action="processupload.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
					  <div class="control-group <?php echo !empty($typeError)?'error':'';?>">
					    <label class="control-label">Type du projet</label>
					    <div class="controls">
					      	
							<select style="width:150px" name="type" class="champs_parcourir" id="type">
							<option value="projet" > Projet </option>
							<option value="Activité" > Activité </option>
							</select>
								<?php if (!empty($typeError)): ?>
					      		<span class="help-inline"><?php echo $typeError;?></span>
					      	<?php endif; ?>
					      
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($typeError)?'error':'';?>">
					    <label class="control-label">Ville</label>
					    <div class="controls">
					      	
							<select style="width:150px" name="ville" class="champs_parcourir" id="ville"><option value="" > Choisir </option><option value="Ariana" cid="0">Ariana</option><option value="Beja" cid="1">Beja</option><option value="Ben Arous" cid="2">Ben Arous</option><option value="Bizerte" cid="3">Bizerte</option><option value="Gabes" cid="4">Gabes</option><option value="Gafsa" cid="5">Gafsa</option><option value="Jendouba" cid="6">Jendouba</option><option value="Kairouan" cid="7">Kairouan</option><option value="Kasserine" cid="8">Kasserine</option><option value="Kebili" cid="9">Kebili</option><option value="Kef" cid="10">Kef</option><option value="Mahdia" cid="11">Mahdia</option><option value="Mannouba" cid="12">Mannouba</option><option value="Medenine" cid="13">Medenine</option><option value="Monastir" cid="14">Monastir</option><option value="Nabeul" cid="15">Nabeul</option><option value="Sfax" cid="16">Sfax</option><option value="Sidi Bouzid" cid="17">Sidi Bouzid</option><option value="Siliana" cid="18">Siliana</option><option value="Sousse" cid="19">Sousse</option><option value="Tataouine" cid="20">Tataouine</option><option value="Tozeur" cid="21">Tozeur</option><option value="Tunis" cid="22">Tunis</option><option value="Zaghouan" cid="23">Zaghouan</option></select>
								<?php if (!empty($villeError)): ?>
					      		<span class="help-inline"><?php echo $villeError;?></span>
					      	<?php endif; ?>
					      
					    </div>
					  </div>
					  
					  
					  <div class="control-group <?php echo !empty($image_fileError)?'error':'';?>">
					    <label class="control-label">Image du projet</label>
					    <div class="controls">
														
							<input name="image_file" id="imageInput" type="file" />
							<input type="submit"  id="submit-btn" value="Créer" />

							<img src="bootstrap/ajax-image-upload/images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
							
							
					      	<?php if (!empty($image_fileError)): ?>
					      		<span class="help-inline"><?php echo $image_fileError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					   <div class="form-actions">
						<div id="output"></div>
						</div>
						
					  </div>
					    </div>
					 
						
						
					</form>
				
				


	
	
<!--
<div id="upload-wrapper">
<div align="center">
<h3>Image du Projet  </h3>
<form action="processupload.php" method="post" enctype="multipart/form-data" id="MyUploadForm">

<select style="width:150px" name="type" class="champs_parcourir" id="type">
<option value="projet" > Projet </option>
<option value="Activité" > Activité </option>
</select>

<select style="width:150px" name="ville" class="champs_parcourir" id="ville"><option value="" > Choisir </option><option value="Ariana" cid="0">Ariana</option><option value="Beja" cid="1">Beja</option><option value="Ben Arous" cid="2">Ben Arous</option><option value="Bizerte" cid="3">Bizerte</option><option value="Gabes" cid="4">Gabes</option><option value="Gafsa" cid="5">Gafsa</option><option value="Jendouba" cid="6">Jendouba</option><option value="Kairouan" cid="7">Kairouan</option><option value="Kasserine" cid="8">Kasserine</option><option value="Kebili" cid="9">Kebili</option><option value="Kef" cid="10">Kef</option><option value="Mahdia" cid="11">Mahdia</option><option value="Mannouba" cid="12">Mannouba</option><option value="Medenine" cid="13">Medenine</option><option value="Monastir" cid="14">Monastir</option><option value="Nabeul" cid="15">Nabeul</option><option value="Sfax" cid="16">Sfax</option><option value="Sidi Bouzid" cid="17">Sidi Bouzid</option><option value="Siliana" cid="18">Siliana</option><option value="Sousse" cid="19">Sousse</option><option value="Tataouine" cid="20">Tataouine</option><option value="Tozeur" cid="21">Tozeur</option><option value="Tunis" cid="22">Tunis</option><option value="Zaghouan" cid="23">Zaghouan</option></select>

<input name="image_file" id="imageInput" type="file" />
<input type="submit"  id="submit-btn" value="Créer" />

<img src="bootstrap/ajax-image-upload/images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
</form>
<div id="output"></div>
</div>
</div>
-->
	