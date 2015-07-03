
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
		$sql = "SELECT a.* FROM "._DB_PREFIX_."presse a where a.id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		
		
		$image = $data['image'];
		//var_dump($data);
		
		Database::disconnect();
	}
	
	

?>

<script type="text/javascript">
$(document).ready(function() { 

	//select type and presse
	$('#type').val("<?=$type;?>");
	$('#ville').val("<?=$ville?>");
	
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
	<a class="btn" href="index.php?page=presse&action=index#<?=$id;?>&pagi=<?=$pagi;?>">Back</a>
	
  </div>
  
		
    				<div id="upload-wrapper" style="width:100%">
					<div align="center">
					
		    			<h3>Changer l'Image </h3>
		    		<div id="alert">
		  
					</div>
					<form class="form-horizontal" action="processuploadpresse.php?id=<?=$id;?>" method="post" enctype="multipart/form-data" id="MyUploadForm">
					
					  
					  
					  <div class="control-group <?php echo !empty($image_fileError)?'error':'';?>">
					    <label class="control-label">Image du presse</label>
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
							echo '<img src="uploads_presse/'.$thumb_prefix . $image.'" alt="Thumbnail">';
							echo '<img src="uploads_presse/' . $image.'" alt="">';
							echo '<script>$(document).ready(function() {  
							} );
							 </script>';
							//echo '<br />';
							//echo '<img src="uploads/'. $new_file_name.'" alt="Resized Image">';
							echo '</div>';?>
						
						</div>
						</div>
						
					  </div>
					    </div>
					 
						
						
					</form>
				
				


	
	
	