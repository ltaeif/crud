<?php
require 'config.php';
//header("Content-Type: application/json");
$folder = $_POST["folder"];
$jsonData = '{';
$dir = $folder."/";

$from=0;
$pagi=0;
$page=0;
//$nbre_par_page=5;

if(isset($_POST['pagi']) && !empty($_POST['pagi'])) $pagi=$_POST['pagi'];	

$page=$pagi;
$pdo = Database::connect();
$nbligne='SELECT COUNT(*) FROM '._DB_PREFIX_.'album ';
$resultat=$pdo->query($nbligne);
foreach ($resultat as $row) {}
//limit '.$from.','.$nbre_par_page;
$nb_de_ligne = $row[0];

$nb_de_page=$nb_de_ligne/$nbre_par_page;
$from=$nbre_par_page*$pagi;


			$pagination='<ul class="pager" style="font-size: 20px;">';
						  
			if($nb_de_page >($page+1))
			{ 
			 $pagenesx=$page+1;
			 $pagination.="<li class=\"next\"><a href=\"javascript:ajax_json_gallery('albums','$pagenesx')\" >Next &rarr;</a></li>";
			}
			
			if($page > 0){ 
			$pagenesx=$page-1;
			$pagination.="<li class=\"previous\"><a href=\"javascript:ajax_json_gallery('albums','$pagenesx')\" >Previous &rarr;</a></li>";
			}
			
			$pagination.="</ul>";
			
			
			
			$pagination=htmlentities($pagination);
			
				//select the last image name
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "SELECT * FROM "._DB_PREFIX_."album ORDER BY id DESC limit ".$from.",".$nbre_par_page;			
					//echo json_encode($sql);exit;
					foreach ($pdo->query($sql) as $row) {
					    
						$id=$row['id'];
						$file = $row['image'];	
						$id= $row['id'];
						if(!is_dir($file) && preg_match("/.jpg|.gif|.png/i", $file)){
								$i++;
								$src = "$dir$file";
						$jsonData .= '"img'.$i.'":{ "id":"'.$id.'","num":"'.$i.'","src":"'.$src.'", "name":"'.$file.'",' ;
						$pagination2='"pagination" : "'.$pagination.'"';
						$jsonData .= $pagination2;
						$jsonData .='},';
							}
					}
			//pagination
			//$pagination=' "ids":"'.$id.'" ' .'},';
			//$jsonData .= $pagination;
			//$jsonData .= ', "pagination": "'.serialize($pagination).'" '.'}';
				
$jsonData = chop($jsonData, ",");
$jsonData .= '}';
echo $jsonData;	
?>