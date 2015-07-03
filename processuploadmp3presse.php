<?php
require 'config.php';

$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
//continue only if $_POST is set and it is a Ajax request
if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{

	// check $_FILES['ImageFile'] not empty
	if(!isset($_FILES['file']) || !is_uploaded_file($_FILES['file']['tmp_name'])){
			die('File is Missing!'); // output error when above checks fail.
	}
	

	
	
	//uploaded file info we need to proceed
	$file_name = $_FILES['file']['name']; //file name
	$file_size = $_FILES['file']['size']; //file size
	$file_temp = $_FILES['file']['tmp_name']; //file temp
	$extension = substr($file_name, strrpos($file_name, '.') + 1); // getting the info about the image&nbsp;to get its extension

	

	//switch statement below checks allowed image type 
	//as well as creates new image from given file
	
	
	$allowedExts = array( "mp3", "mp4", "wma");
	//echo $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
	
	
	
	$file_res = false;
	$file_res =in_array($extension, $allowedExts);
	
	if($file_res){
		
		if ($_FILES["file"]["error"] > 0)
		{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
		}
		else
		{
			echo "Upload: " . $_FILES["file"]["name"] . "<br&nbsp;/>";
			echo "Type: " . $_FILES["file"]["type"] . "<br />";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
			echo "Temp file:&nbsp;" . $_FILES["file"]["tmp_name"] . "<br />";
	 
		if (file_exists("sons/" . $_FILES["file"]["name"]))
		  {
			echo $_FILES["file"]["name"] . " already&nbsp;exists. ";
		  }
		else
		  {
		  	//Get file extension and name to construct new file name 
			$file_info = pathinfo($file_name);
			$file_extension = strtolower($file_info["extension"]); //image extension
			$file_name_only = strtolower($file_info["filename"]);//file name only, no extension
			
			//create a random name for new image (Eg: fileName_293749.jpg) ;
			$new_file_name =   rand(0, 9999999999) . '.' . $file_extension;
			
			//folder path to save resized images and thumbnails
			$file_save_folder 	= $destination_folder_son_presse . $new_file_name;
		  
		   move_uploaded_file($_FILES["file"]["tmp_name"],"sons/" .$new_file_name );
		   echo "Stored in: " . "sons/" . $new_file_name ;
		   
		   save_file_db($id,$new_file_name);
		  }
		}
		
	
		
		
	}
}





function save_file_db($id,$new_file_name)
{

if ( null==$id ) {
			
			//save into db
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//update unique presse
			
			$sql = "INSERT INTO "._DB_PREFIX_."presse (mp3,ajoutdate) values( ?, ?)";
			$q = $pdo->prepare($sql);
			$date = date('Y-m-d');
			
			$q->execute(array( $new_file_name, $date));
			$id = $pdo->lastInsertId();
			
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
					$mp3 = $data['mp3'];
					$pdo->commit(); 
					
					//echo _ASS_UPLOAD_SON_PRESSE_DIR_."$mp3";
					//delete from folder
				  if(file_exists(_ASS_UPLOAD_SON_PRESSE_DIR_."$mp3")) 
					 {
					$result =  @unlink(_ASS_UPLOAD_SON_PRESSE_DIR_."$mp3"); 				
					 
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
					$sql = "UPDATE "._DB_PREFIX_."presse  set mp3 = ? , ajoutdate = ?  WHERE id = ?";
					$q = $pdo->prepare($sql);
					$date = date('Y-m-d');
					$q->execute(array( $new_file_name,$date,$id));
					
					
				
				Database::disconnect();
			
			}
			
			return $id;

}