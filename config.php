<?php 
	
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));

	require 'database.php';
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	if (!defined('_PS_MAGIC_QUOTES_GPC_'))
	define('_PS_MAGIC_QUOTES_GPC_',         get_magic_quotes_gpc());
	
	require_once 'bootstrap/htmlpurifier/library/HTMLPurifier.auto.php';

	
	
	
	
	define('_DB_PREFIX_', 'fsa_');
	$currentDir = dirname(__FILE__);
	if (!defined('_ASS_ROOT_DIR_'))
	define('_ASS_ROOT_DIR_', realpath($currentDir.DIRECTORY_SEPARATOR));
	define('_ASS_UPLOAD_DIR_',_ASS_ROOT_DIR_.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR);	
	define('_ASS_UPLOAD_SON_PRESSE_DIR_',_ASS_ROOT_DIR_.DIRECTORY_SEPARATOR.'sons'.DIRECTORY_SEPARATOR);	
	define('_ASS_UPLOAD_VIDEO_PRESSE_DIR_',_ASS_ROOT_DIR_.DIRECTORY_SEPARATOR.'videos'.DIRECTORY_SEPARATOR);	
	define('_ASS_UPLOAD_PRESSE_DIR_',_ASS_ROOT_DIR_.DIRECTORY_SEPARATOR.'uploads_presse'.DIRECTORY_SEPARATOR);	
	define('_ASS_ALBUM_UPLOAD_DIR_',_ASS_ROOT_DIR_.DIRECTORY_SEPARATOR.'albums'.DIRECTORY_SEPARATOR);	
	
	define('_ASS_UPLOAD_SON2_PROJET_DIR_',_ASS_ROOT_DIR_.DIRECTORY_SEPARATOR.'sons2'.DIRECTORY_SEPARATOR);	
	define('_ASS_UPLOAD_VIDEO2_PROJET_DIR_',_ASS_ROOT_DIR_.DIRECTORY_SEPARATOR.'videos2'.DIRECTORY_SEPARATOR);
	

	############ Configuration ##############
	$thumb_square_size 		= 200; //Thumbnails will be cropped to 200x200 pixels
	$thumb_square_size_album = 150; //Thumbnails will be cropped to 200x200 pixels
	$max_image_size 		= 500; //Maximum image size (height and width)
	$thumb_prefix			= "thumb_"; //Normal thumb Prefix
	
	$destination_folder		= _ASS_UPLOAD_DIR_; //upload directory ends with / (slash)
	$destination_folder_presse	= _ASS_UPLOAD_PRESSE_DIR_; //upload directory ends with / (slash)
	$destination_folder_son_presse	= _ASS_UPLOAD_SON_PRESSE_DIR_; //upload directory ends with / (slash)
	$destination_folder_video_presse	= _ASS_UPLOAD_VIDEO_PRESSE_DIR_; //upload directory ends with / (slash)
	
	$destination_folder_album	= _ASS_ALBUM_UPLOAD_DIR_; //upload directory ends with / (slash)
	
	
	$destination_folder_album_thumb	= _ASS_ALBUM_UPLOAD_DIR_.'thumbs'.DIRECTORY_SEPARATOR; //upload directory ends with / (slash)
	
	$jpeg_quality 			= 90; //jpeg quality
	##########################################
	
	$langue= array('fr','en','ar');
	$nbre_par_page = 3;
			
    header('Content-Type: text/html; charset=utf-8'); 
    session_start(); 
	
function coupeCourt($texte,$long,$marge=10){
	try{
	
			$msg = stripslashes($texte) ;
			$msg = preg_replace("'<[^>]+>'U", "", trim(strip_tags($msg)) ) ;
			$taille = strlen($msg) ;
			if($long < $taille){
				$message = substr($msg, 0, $long) ;
				$i = $long ;
				if ($i < $taille){ 
					while ($msg[$i] != " " && isset($msg[$i]) && $i < ($long+$marge) ){
						$message .= $msg[$i] ;
						$i++ ;
					}
				}
				if ($i < $taille){
					$message .= "..." ;
				}
			}else{
				$message = $msg ;
			}
	} catch(PDOExecption $e) { 
				return ($message) ;	
			} 
	return ($message) ;
}

function mkdir_r($dirName, $rights=0777){
    $dirs = explode('/', $dirName);
    $dir='';
    foreach ($dirs as $part) {
        $dir.=$part.'/';
        if (!is_dir($dir) && strlen($dir)>0)
            mkdir($dir, $rights);
    }
}

//create folder

function makeDir($path)
{
     $ret = mkdir($path); // use @mkdir if you want to suppress warnings/errors
     return $ret === true || is_dir($path);
}

/** 
 * recursively create a long directory path
 */
function createPath($path) {
    if (is_dir($path)) return true;
    $prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
    $return = createPath($prev_path);
	
    return ($return && is_writable($prev_path)) ? mkdir($path) : false;
}


function baseUrl(){

    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }

    $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);


    return $protocol . "://" . $_SERVER['HTTP_HOST'] . str_replace('/index.php','',$uri_parts[0]);
/*
    return sprintf(
        "%s://%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $_SERVER['REQUEST_URI']
    );
*/
}
	
	
?>