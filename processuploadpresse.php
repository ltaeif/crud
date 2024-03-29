<?php
require 'config.php';



$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	
	

//continue only if $_POST is set and it is a Ajax request
if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

	// check $_FILES['ImageFile'] not empty
	if(!isset($_FILES['image_file']) || !is_uploaded_file($_FILES['image_file']['tmp_name'])){
			die('Image file is Missing!'); // output error when above checks fail.
	}
	
	$type = $_POST['type'];
	$ville= $_POST['ville'];
	
	
	//uploaded file info we need to proceed
	$image_name = $_FILES['image_file']['name']; //file name
	$image_size = $_FILES['image_file']['size']; //file size
	$image_temp = $_FILES['image_file']['tmp_name']; //file temp

	$image_size_info 	= getimagesize($image_temp); //get image size
	
	if($image_size_info){
		$image_width 		= $image_size_info[0]; //image width
		$image_height 		= $image_size_info[1]; //image height
		$image_type 		= $image_size_info['mime']; //image type
	}else{
		die("Make sure image file is valid!");
	}

	//switch statement below checks allowed image type 
	//as well as creates new image from given file 
	switch($image_type){
		case 'image/png':
			$image_res =  imagecreatefrompng($image_temp); break;
		case 'image/gif':
			$image_res =  imagecreatefromgif($image_temp); break;			
		case 'image/jpeg': case 'image/pjpeg':
			$image_res = imagecreatefromjpeg($image_temp); break;
		default:
			$image_res = false;
	}

	if($image_res){
		//Get file extension and name to construct new file name 
		$image_info = pathinfo($image_name);
		$image_extension = strtolower($image_info["extension"]); //image extension
		$image_name_only = strtolower($image_info["filename"]);//file name only, no extension
		
		//create a random name for new image (Eg: fileName_293749.jpg) ;
		$new_file_name = $image_name_only. '_' .  rand(0, 9999999999) . '.' . $image_extension;
		
		//folder path to save resized images and thumbnails
		$thumb_save_folder 	= $destination_folder_presse . $thumb_prefix . $new_file_name; 
		$image_save_folder 	= $destination_folder_presse . $new_file_name;
		
		//echo $image_save_folder;
		//call normal_resize_image() function to proportionally resize image
		if(normal_resize_image($image_res, $image_save_folder, $image_type, $max_image_size, $image_width, $image_height, $jpeg_quality))
		{
			//call crop_image_square() function to create square thumbnails
			if(!crop_image_square($image_res, $thumb_save_folder, $image_type, $thumb_square_size, $image_width, $image_height, $jpeg_quality))
			{
				die('Error Creating thumbnail');
			}
			
			
			$id=save_image_db($langue,$id,$new_file_name);
		
			
			//creat folder for album
			//makeDir(_ASS_ALBUM_UPLOAD_DIR_.$id);
			
			
			
			/* We have succesfully resized and created thumbnail image
			We can now output image to user's browser or store information in the database*/
			echo '<div align="center">';
			echo '<img src="uploads_presse/'.$thumb_prefix . $new_file_name.'" alt="Thumbnail">';
			echo '<img src="uploads_presse/' . $new_file_name.'" alt="">';
			echo '<script>$(document).ready(function() {  
			 
			 //$("#date").val("'.$_POST['date'].'"); 
			 
			var act= $("#MyUploadForm").attr("action"); 
			$("#MyUploadForm").attr("action","processuploadpresse.php?id='.$id.'"); }); </script>';
			//echo '<br />';
			//echo '<img src="uploads/'. $new_file_name.'" alt="Resized Image">';
			echo '</div>';
			
			
			
		}
		
		imagedestroy($image_res); //freeup memory
	}
}


#####  This function will proportionally resize image ##### 
function normal_resize_image($source, $destination, $image_type, $max_size, $image_width, $image_height, $quality){
	
	if($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize
	
	//do not resize if image is smaller than max size
	if($image_width <= $max_size && $image_height <= $max_size){
		if(save_image($source, $destination, $image_type, $quality)){
			return true;
		}
	}
	
	//Construct a proportional size of new image
	$image_scale	= min($max_size/$image_width, $max_size/$image_height);
	$new_width		= ceil($image_scale * $image_width);
	$new_height		= ceil($image_scale * $image_height);
	
	$new_canvas		= imagecreatetruecolor( $new_width, $new_height ); //Create a new true color image
	
	//Copy and resize part of an image with resampling
	if(imagecopyresampled($new_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height)){
		save_image($new_canvas, $destination, $image_type, $quality); //save resized image
	}

	return true;
}

##### This function corps image to create exact square, no matter what its original size! ######
function crop_image_square($source, $destination, $image_type, $square_size, $image_width, $image_height, $quality){
	if($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize
	
	if( $image_width > $image_height )
	{
		$y_offset = 0;
		$x_offset = ($image_width - $image_height) / 2;
		$s_size 	= $image_width - ($x_offset * 2);
	}else{
		$x_offset = 0;
		$y_offset = ($image_height - $image_width) / 2;
		$s_size = $image_height - ($y_offset * 2);
	}
	$new_canvas	= imagecreatetruecolor( $square_size, $square_size); //Create a new true color image
	
	//Copy and resize part of an image with resampling
	if(imagecopyresampled($new_canvas, $source, 0, 0, $x_offset, $y_offset, $square_size, $square_size, $s_size, $s_size)){
		save_image($new_canvas, $destination, $image_type, $quality);
	}

	return true;
}

##### Saves image resource to file ##### 
function save_image($source, $destination, $image_type, $quality){
	switch(strtolower($image_type)){//determine mime type
		case 'image/png': 
			imagepng($source, $destination); return true; //save png file
			break;
		case 'image/gif': 
			imagegif($source, $destination); return true; //save gif file
			break;          
		case 'image/jpeg': case 'image/pjpeg': 
			imagejpeg($source, $destination, $quality); return true; //save jpeg file
			break;
		default: return false;
	}
	
	
	
		
}



function save_image_db($langue,$id,$new_file_name)
{

if ( null==$id ) {
			
			//save into db
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//update unique presse
			
			$sql = "INSERT INTO "._DB_PREFIX_."presse (image,ajoutdate) values( ?, ?)";
			$q = $pdo->prepare($sql);
			$date = date('Y-m-d');
			
			$q->execute(array( $new_file_name, $date));
			$id = $pdo->lastInsertId();
			
			
			
			//insert new ligne lang presse
			foreach ($langue as $key => $value)
			{
			
			$sql = "INSERT INTO "._DB_PREFIX_."presse_lang (lang,titre,id_presse) values( ?, ?,?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($value,'titre',$id));
			}
			
			Database::disconnect();
			
			}
			else{
			
			
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
					$image = $data['image'];
					$pdo->commit(); 
					
					//delete from folder
				  if(file_exists(_ASS_UPLOAD_PRESSE_DIR_."$image")) 
					 {
					
					 $result =  @unlink(_ASS_UPLOAD_PRESSE_DIR_."$image"); 				
					 $result =  @unlink(_ASS_UPLOAD_PRESSE_DIR_.$thumb_prefix."$image"); 				
					 }
					
				} catch(PDOExecption $e) { 
					$pdo->rollback(); 
					print "Error!: " . $e->getMessage() . "</br>"; 
				} 
				
						Database::disconnect();
				
			} catch( PDOExecption $e ) { 
				print "Error!: " . $e->getMessage() . "</br>"; 
			} 
				
					$pdo = Database::connect();				
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "UPDATE "._DB_PREFIX_."presse  set image = ? , ajoutdate = ?  WHERE id = ?";
					$q = $pdo->prepare($sql);
					$date = date('Y-m-d');
					$q->execute(array( $new_file_name,$date,$id));
					
					
				
				Database::disconnect();
			
			}
			
			return $id;

}