<?php

$pdo = Database::connect();
$id = null;
$from=0;
//$nbre_par_page=2;
$pagi=0;

if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
		
		//echo '<script type="text/javascript">location.href="ligne#'.$id.'";<script>';
	}
	
if(isset($_GET['pagi']) && !empty($_GET['pagi'])) $pagi=$_GET['pagi'];	

$nbligne='SELECT COUNT(*) FROM '._DB_PREFIX_.'projet ';
$resultat=$pdo->query($nbligne);
foreach ($resultat as $row) {}
//limit '.$from.','.$nbre_par_page;
$nb_de_ligne = $row[0];
$nb_de_page=$nb_de_ligne/$nbre_par_page;
$from=$nbre_par_page*$pagi;

	
	
?>
<style>
 .toggle {
   
    
  }
 </style>
  


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
	
	
<script type="text/javascript">

	var currentclass='';
	var currenthtml='';
	
	function overenter(id)
	{	
		currentclass=$('#publier'+id).attr( 'class');
		currenthtml=$('#publier'+id).html();
		console.log($('#publier'+id).html());
		 if($('#publier'+id).html()=='actif') 
			 {
			 $('#publier'+id).removeClass( 'btn-info' );
			 $('#publier'+id).addClass( 'btn-danger' );
			 $('#publier'+id).html('désactiver');
			 }
			 
			 if($('#publier'+id).html()=='inactif') 
			 {
			 $('#publier'+id).removeClass( 'btn-danger' );
			 $('#publier'+id).addClass( 'btn-info' );
			 $('#publier'+id).html('activer');
			 }
	}
	
	function overleave(id)
	{
		$('#publier'+id).attr( 'class','');
		$('#publier'+id).attr('class',currentclass);
		console.log(currenthtml);
		$('#publier'+id).html(currenthtml);
	}
	
	
  
  
  
	function overm(id)
	{
	
	 currentclass=$('#publier'+id).attr( 'class');
	 currenthtml=$('#publier'+id).html();

	$("#publier"+id).hover(
		  function() {
			 
			 if($(this).html()=='actif') 
			 {
			 $(this).removeClass( 'btn-info' );
			 $(this).addClass( 'btn-danger' );
			 $(this).html('désactiver');
			 }
			 
			 if($(this).html()=='inactif') 
			 {
			 $(this).removeClass( 'btn-danger' );
			 $(this).addClass( 'btn-info' );
			 $(this).html('activer');
			 }
				 
		  }, function() {
			   $(this).attr( 'class','');
			   $(this).attr('class',currentclass);
			   console.log(currenthtml);
			   $(this).html(currenthtml);
			  //if($(this).html()=='inactif') $(this).html('activer');
		  }
		);
	}
	
	function updatepublier(id,publier)
	{
		
		
		

			$.ajax({
			   url : 'processpublier.php', // La ressource ciblée
			   data : 'id='+id+'&publier='+publier,
			   type : 'GET', // Le type de la requête HTTP.
			   success : function(data){ // code_html contient le HTML renvoyé
					//$(data).appendTo("#commentaires");
					console.log(data);
					//if(data.publier==0) $('#publier'+id).attr('class','btn btn-danger');
					if ( data==0 ) {
					  $('#publier'+id).removeClass( 'btn-info' );
					  $('#publier'+id).addClass( 'btn-danger' );
					  $('#publier'+id).html('inactif');
					
					  //$('#publier'+id).attr('Activer');
					} else {
					  $('#publier'+id).removeClass( 'btn-danger' );
					  $('#publier'+id).addClass( 'btn-info' );
					   $('#publier'+id).html('actif');
					  //$('#publier'+id).attr('Désactiver');
					
					}
					
					  currentclass=$('#publier'+id).attr( 'class');
					  currenthtml=$('#publier'+id).html();
					  
					  
					  var c= "updatepublier("+id+","+data+");return false;";
					   $('#publier'+id).attr('onclick',c);
					
					//if(data.publier==1) $('publier'+).attr('class','btn btn-danger');
					}
				});
			
			    return false;
	}	
$(document).ready(function() { 

/*
 if (location.href.indexOf("#") != -1) {
        // Your code in here accessing the string like this
        // location.href.substr(location.href.indexOf("#"))
		alert(location.href.indexOf("#"));
    }
	if($(window.location.hash).length > 0){
        $('html, body').animate({ scrollTop: $(window.location.hash).offset().top}, 1000);
}
*/

	var currentclass=$( '.publier').attr( 'class');
	var currenthtml=$( '.publier').html();
	
	var url = location.href,
    hash = url.split('#')[1];

	if (hash) {
		//alert(hash);
		 //$('html, body').animate({ scrollTop: $(window.location.hash).offset().top}, 1000);
		 //location.hash = '#ligne'+hash;
		 //window.location.hash = '#ligne'+hash;
		 //$('#ligne'+hash).scrollView();
		 
		$('html,body').animate({
                scrollTop: $('#ligne'+hash).offset().top-50
         }, 1000);
			
		$('#ligne'+hash).effect( "highlight", {color:"#ffff99"}, 4000 );
			
			 
		
	} else {
		// do something else
	}
	
	//#ligne
				
	
		
		

/*
$( '.publier').hover(
		  function() {
			 
			 if($(this).html()=='actif') 
			 {
			 $(this).removeClass( 'btn-info' );
			 $(this).addClass( 'btn-danger' );
			 $(this).html('désactiver');
			 }
			 else
			 {
			 $(this).removeClass( 'btn-danger' );
			 $(this).addClass( 'btn-info' );
			 $(this).html('activer');
			 }
			 
		  }, function() {
			   $(this).removeClass( 'btn-danger' );
			   $(this).addClass( 'btn-info' );
			  if($(this).html()=='inactif') $(this).html('activer');
		  }
		);*/
}); 	
	</script>	
    <div class="container">
    		<div class="row">
    			<h3>Projet ou Activité</h3>
    		</div>
			<div class="row">
				<p>
					<a href="index.php?page=projet&action=create_projet&pagi=<?=$pagi;?>" class="btn btn-success">Ajouter</a>
				</p>
				
				
								  <ul class="pager" style="font-size: 30px;margin:18px 159px 11px 28px">
						  

								<?php  if($nb_de_page >($pagi+1)){ $paginesx=$pagi+1;?>
									<li class="next"><a href="index.php?page=projet&action=index&pagi=<?php echo $paginesx;?>">Next </a></li>
								<?php } ?>
									
								<?php  if($pagi > 0){ $paginesx=$pagi-1;?>
									<li class="previous"><a href="index.php?page=projet&action=index&pagi=<?php echo $paginesx;?>">Previous </a></li>
								<?php } ?>
									</ul>		
				
				<table class="table table-striped table-bordered" style="">
		              <thead>
		                <tr>
						  <th style="width:10px">Id</th>
		                  <th style="width:10px">Medias : Image,video,mp3</th>
		                  <th style="width:20px">Type</th>
						  <th style="width:20px">Ville</th>
						  <th style="width:25px">Date</th>
		                  <th style="width:170px">Détails</th>
		                  <th style="width:100px">Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   
					   
					   $sql = 'SELECT p.*,pl.ville FROM '._DB_PREFIX_.'projet p LEFT JOIN '._DB_PREFIX_.'projet_lang pl ON pl.id_projet=p.id GROUP BY p.id ORDER BY p.id DESC limit '.$from.','.$nbre_par_page;
	 				   foreach ($pdo->query($sql) as $row) {
								
								$id=$row['id'];
						   		echo '<tr class="" id="ligne'. $row['id'] . '">';
								echo '<td >'. $row['id'] . '</td>';
							   	echo '<td>
								<img src="uploads/'.$thumb_prefix.$row['image'] . '" />';
								echo '<table><tr>';
								
								
								echo '<td>
								<a href="sons2/'. $row['mp3'].'" >'. $row['mp3'].'</a>' ;
								echo '<br>
								
								<a href="javascript:void(0);"  title="modifier son" 
								onclick="location.href=\'index.php?page=projet&action=update_projet_mp3&id='.$id.'&pagi='.$pagi.'\'; "
								class=" btn btn-success">
								<i class="icon-music icon-white"></i></a>';
								
								if($row['mp3']!='')
								echo '<a href="javascript:void(0);"  title="supprimer son" 
								onclick="location.href=\'index.php?page=projet&action=delete_projet_mp3&id='.$id.'&pagi='.$pagi.'\'; "
								class=" btn btn-danger">
								<i class="icon-remove icon-white"></i></a>
								
								';
								
							   	echo '&nbsp;';
								echo '</td>';
								echo '<td>
								<a href="videos2/'. $row['video'].'" >'. $row['video'].'</a>' ;
								echo '<br>
								
								<a href="javascript:void(0);"  title="modifier video" 
								onclick="location.href=\'index.php?page=projet&action=update_projet_video&id='.$id.'&pagi='.$pagi.'\'; "
								class=" btn btn-success">
								<i class="icon-facetime-video icon-white"></i></a>';
								
								if($row['video']!='')
								echo '<a href="javascript:void(0);"  title="supprimer video" 
								onclick="location.href=\'index.php?page=projet&action=delete_projet_video&id='.$id.'&pagi='.$pagi.'\'; "
								class=" btn btn-danger">
								<i class="icon-remove icon-white"></i></a>
								
								';
							
							   	echo '&nbsp;';
								echo '</td>';
								
								echo '</tr></table>';
								
								echo '</td>';
								echo '<td >'. $row['type'] . '</td>';
							   	echo '<td >'. $row['ville'] . '</td>';
								echo '<td >'. $row['ajoutdate'] . '</td>';
							   	echo '<td  >';
								
								?>
									<table class="table table-striped table-bordered" style="">
									  <thead>
										<tr>
										  <th>Titre</th>
										  <th>Description</th>
										  <th>Langue</th>
										  <th >Action</th>
										</tr>
									  </thead>
									  <tbody>
									<?php
								
								 $sql = 'SELECT * FROM '._DB_PREFIX_.'projet_lang where id_projet = '.$row['id'].' ORDER BY id DESC';
									foreach ($pdo->query($sql) as $row1) {
									echo '<tr>';
									echo '<td >'.$row1['titre'] . '</td>';
									echo '<td >'.coupeCourt($row1['description'],10) . '</td>';
									echo '<td ><span class="label label-primary">'. $row1['lang'] . '</span></td>';
									echo '<td >';
									echo '<a class="btn btn-success" title="Mise à jour" href="index.php?page=projet&action=update_projet_lang&id='.$row1['id'].'&id_projet='.$row['id'].'&pagi='.$pagi.'"><i class="icon-edit icon-white"></i></a>';
									echo '&nbsp;';
									echo '<a class="btn" title="voir" href="index.php?page=projet&action=read&id='.$row1['id'].'&id_projet='.$row['id'].'&pagi='.$pagi.'"><i class="icon-eye-open icon-black"></i></a>';
									echo '</td>';
									echo '</tr>';
									
									}
								
								?>
									 </tbody>
									 </table>
								
									<?php
								
								
								echo  '</td>';
							   	echo '<td>';
							   
							   	echo '<a class="btn btn-success" title="Mise à jour" href="index.php?page=projet&action=update_projet&id='.$row['id'].'&pagi='.$pagi.'"><i class="icon-edit icon-white"></i></a>';
							   	
								echo '&nbsp;';
							   	if($row['publier']==1)
								echo '<a onmouseenter="overenter('.$row['id'].')" onmouseleave="overleave('.$row['id'].')" onclick="updatepublier('.$row['id'].','.$row['publier'].');return false;" class="publier btn btn-info" id="publier'.$row['id'].'" href="">actif</a>';
								else 
								echo '<a onmouseenter="overenter('.$row['id'].')" onmouseleave="overleave('.$row['id'].')" onclick="updatepublier('.$row['id'].','.$row['publier'].');return false;" class="publier btn btn-danger" id="publier'.$row['id'].'" href="">inactif</a>';
								//index.php?page=projet&action=publier&id='.$row['id'].'
								echo '&nbsp;';
							   	echo '<a class="btn btn-danger" title="Supprimer" href="index.php?page=projet&action=delete&id='.$row['id'].'&pagi='.$pagi.'"><i class="icon-remove icon-white"></i></a>';
							   
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
    	</div>
</div> <!-- /container -->

<!--
<img class="btn btn-success"  src="bootstrap/img/modify.png" style="width:25px;cursor:pointer;" 
								title="modifier son" 
								onclick="location.href=\'index.php?page=projet&action=update_projet_mp3&id='.$.'&pagi='.$.'\'; "/>
-->								
								