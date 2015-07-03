
<script type="text/javascript" src="bootstrap/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="bootstrap/bootstrap-datepicker/js/bootstrap-datepicker.fr.min.js"></script>
<link href="bootstrap/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
<?php 
	
	
$typeError = null;
		$image_fileError = null;
		$villeError = null;
	

			
			
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	$pagi=0;
	if ( !empty($_GET['pagi'])) {
		$pagi = $_REQUEST['pagi'];
		
	}	
	if ( null==$id ) {
		header("Location: index.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT a.*,al.ville FROM "._DB_PREFIX_."projet a left join "._DB_PREFIX_."projet_lang al ON a.id = al.id_projet  where a.id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		
		$type = $data['type'];
		$date = $data['ajoutdate'];
		$ville = $data['ville'];
		$image = $data['image'];
		//var_dump($data);
		
		Database::disconnect();
	}
	
	

?>

<script type="text/javascript">
$(document).ready(function() { 

	//select type and projet
	$('#type').val("<?=$type;?>");
	$('#ville').val("<?=$ville?>");
	$('#date').val("<?=$date?>");
	
	$('#date').datepicker({
		format: "yyyy-mm-dd",
		todayBtn: false,
		
		language: "fr",
		orientation: "top right",
		forceParse: false,
		autoclose: true,
		todayHighlight: true
	});
	
	var options = { 
			target: '#output',   // target element(s) to be updated with server response 
			beforeSubmit: beforeSubmit,  // pre-submit callback 
			success: afterSuccess,  // post-submit callback 
			resetForm: true        // reset the form after successful submit 
		}; 
		
			
		$("#date").on("changeDate", function(event) {
				$("#date").val(	$("#date").datepicker('getFormattedDate'));
				//ajax
			
				if($('#date').val()!='')
				{
					$('#alert').html('');	
					$.ajax({
					   url : 'processvilletypedate.php', // La ressource ciblée
					   data : 'id='+<?=$id;?>+'&ville='+$('#ville').val()+'&type='+$('#type').val()+'&date='+$('#date').val(),
					   type : 'GET' ,
					   success : function(data){ 
						
							$('#alert').html('<p class="alert alert-success" style="width:350px">Mise à jour éffectué</p>');
					   }
					  // Le type de la requête HTTP.
					});
				}
				else
				{
					$("#alerte").html("Choisir une date?");
					return false
				}
				
		});
	
	//$('#date').change(function() { }); 	
	
	$('#type').change(function() { 
			  
			  	$('#alert').html('');	
			 
			$.ajax({
			   url : 'processvilletypedate.php', // La ressource ciblée
			   data : 'id='+<?=$id;?>+'&ville='+$('#ville').val()+'&type='+$('#type').val()+'&date='+$('#date').val(),
			   type : 'GET' ,
			   success : function(data){ 
				
					$('#alert').html('<p class="alert alert-success" style="width:350px">Mise à jour éffectué</p>');
			   }
			     
			   // Le type de la requête HTTP.
			});
		}); 
		
	$('#ville').change(function() { 
			 	$('#alert').html('');	
		$.ajax({
			   url : 'processvilletypedate.php', // La ressource ciblée
			   data : 'id='+<?=$id;?>+'&ville='+$('#ville').val()+'&type='+$('#type').val()+'&date='+$('#date').val(),
			   type : 'GET' ,
			   success : function(data){ 
			
					$('#alert').html('<p class="alert alert-success" style="width:350px">Mise à jour éffectué</p>');
			   }
			});
			
		}); 	
		
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
	$('#alert').html('<p class="alert alert-success" style="width:350px">Mise à jour éffectué</p>');
	

}

//function to check file size before uploading.
function beforeSubmit(){
	$('#alert').html('');
	
	
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		
		
		
		if( !$('#imageInput').val()  ) //check empty input filed
		{
			$("#alerte").html("Choisir une image?");
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
                $("#alerte").html("<b>"+ftype+"</b> Unsupported file type!");
				return false
        }
		
		//Allowed file size is less than 1 MB (1048576)
		if(fsize>1048576) 
		{
			$("#alerte").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
			return false
		}
				
		$('#submit-btn').hide(); //hide submit button
		$('#loading-img').show(); //hide submit button
		$("#output").html(""); 
		$("#alerte").html("");  		
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
	<a class="btn" href="index.php?page=projet&action=index&pagi=<?=$pagi;?>#<?=$id?>">Back</a>
  </div>
  
		
    				<div id="upload-wrapper" style="width:100%">
					<div align="center">
					
		    			<h3>Mise à jour projet</h3>
		    		<div id="alert">
		  
					</div>
					<form class="form-horizontal" action="processupload.php?id=<?=$id;?>" method="post" enctype="multipart/form-data" id="MyUploadForm">
					  <div class="control-group <?php echo !empty($typeError)?'error':'';?>">
					    <label class="control-label">Type du projet</label>
					    <div class="controls">
					      	
							<select style="width:150px" name="type" class="champs_parcourir" id="type">
							<option value="projet" > Projet </option>
							<option value="activité" > Activité </option>
							</select>
								<?php if (!empty($typeError)): ?>
					      		<span class="help-inline"><?php echo $typeError;?></span>
					      	<?php endif; ?>
					      
					    </div>
					  </div>
					  
					   <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
					    <label class="control-label">Date du projet</label>
					    <div class="controls">
					      	
							
								<div class="input-append date">
								<input type="text" value="" name="date" id="date">
								<span class="add-on"><i class="icon-th"></i></span>
								</div>
								<?php if (!empty($dateError)): ?>
					      		<span class="help-inline"><?php echo $dateError;?></span>
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
					   <div id="alerte"></div>
						<div id="output">
						<?php
							echo '<div align="center">';
							echo '<img src="uploads/'.$thumb_prefix . $image.'" alt="Thumbnail">';
							echo '<img src="uploads/' . $image.'" alt="">';
							echo '<script>
							 </script>';
							//echo '<br />';
							//echo '<img src="uploads/'. $new_file_name.'" alt="Resized Image">';
							echo '</div>';?>
						
						</div>
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
	