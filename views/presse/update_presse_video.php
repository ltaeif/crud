
<?php 
	
	
		$typeError = null;
		$video_fileError = null;
		$villeError = null;
	

			
			
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
		$id_presse=null;
	if ( !empty($_GET['id'])) {
		$id_presse = $_REQUEST['id'];
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
		
		
		$video = $data['video'];
		//var_dump($data);
		
		Database::disconnect();
	}
	
	

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
	$('#alert').html('<p class="alert alert-success" style="width:350px">Mise à jour éffectué</p>');

}

//function to check file size before uploading.
function beforeSubmit(){
	$('#alert').html('');
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		
		
		
		
		if( !$('#file_input').val()  ) //check empty input filed
		{
			$("#alerte").html("Choisir un fichier?");
			return false
		}
		
		var fsize = $('#file_input')[0].files[0].size; //get file size
		var ftype = $('#file_input')[0].files[0].type; // get file type
		console.log(ftype);

		//allow only valid image file types 
		switch(ftype)
        {
            case 'video/mp4': case 'video/webm': case 'video/ogv': case 'video/3gp':  case 'video/x-ms-wmv' : case 'video/x-flv': case 'video/x-msvideo': 
                break;
            default:
                $("#alerte").html("<b>"+ftype+"</b> Unsupported file type!");
				return false
        }
		
		//Taille maximale 10 MB (10485760)
		if(fsize>10485760)
		{
			$("#alerte").html("<b>"+bytesToSize(fsize) +"</b> Too big Video file! <br />Please reduce the size of your photo using an image editor.");
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
	<a class="btn" href="index.php?page=presse&action=index#<?=$id_presse?>">Back</a>
  </div>
  
		
    				<div id="upload-wrapper" style="width:100%">
					<div align="center">
					
		    			<h3>Changer la video </h3>
		    		<div id="alert">
		  
					</div>
					<form class="form-horizontal" action="processuploadvideopresse.php?id=<?=$id;?>" method="post" enctype="multipart/form-data" id="MyUploadForm">
					
					  <p class="alert alert-info" style="width:350px">Taille maximale 10 MB<br>
					  Extension des videos autorisées : Avi, mp4, webm, ogv, 3gp, wmv
					  </p>
					  
					  
					  
					  <div class="control-group <?php echo !empty($video_fileError)?'error':'';?>">
					    <label class="control-label"></label>
					    <div class="controls">
														
							<input name="file" id="file_input" type="file" />
							<input type="submit"  id="submit-btn" value="Créer" />

							<img src="bootstrap/ajax-image-upload/images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
							
							
					      	<?php if (!empty($video_fileError)): ?>
					      		<span class="help-inline"><?php echo $video_fileError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					   <div class="form-actions">
					   <div id="alerte"></div>
						<div id="output">
						<?php
							echo '<div align="center">';
							
							echo '<img src="videos/' . $video.'" alt="">';
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
				
				


	
	
	