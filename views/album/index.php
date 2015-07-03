<?php

$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
$from=0;
//$nbre_par_page=2;
$pagi=0;


	?>

<style>

div#thumbnailbox { float:left; margin-top:82px; width:120px; }
div#thumbnailbox > div { width:100px; height:80px; overflow:hidden; margin:10px; cursor:pointer; }
.image { width:150px;cursor:pointer; }
#pictureframe { margin:50px; cursor:pointer; }

</style>

<script>
function ajax_json_gallery(folder,pagi){
	var thumbnailbox = document.getElementById("thumbnailbox");
	var pictureframe = document.getElementById("pictureframe");
	var pagination = document.getElementById("pagination");
	var pagination2 = document.getElementById("pagination2");
	var paginationh = "";
	
    var hr = new XMLHttpRequest();
    hr.open("POST", "json_gallery_data.php", true);
	
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var d = JSON.parse(hr.responseText);
			//pictureframe.innerHTML = "<img src='"+d.img1.src+"'>";
			thumbnailbox.innerHTML = "";
			console.log(d);
			
			for(var o in d){
				if(d[o].src){
				    thumbnailbox.innerHTML += 
					'<tr><td><div>'+d[o].id+'</div></td><td><div onclick="putinframe(\''+d[o].src+'\')"><img class="image" src="'+d[o].src+'"></div></td>'+
					'<td><a title="Supprimer" class="btn btn-danger" href="index.php?page=album&action=delete&name='+d[o].name+'"><i class="icon-remove icon-white"></i></a></div></td>'
					+'</tr>';
					paginationh = d[o].pagination;
				}
			}
			
			pagination.innerHTML = "";
			//pagination.innerHTML = notWorking('<table><tr><td>Text Here</td></tr></table>');
			//console.log(notWorking(paginationh.slice(2,paginationh.length-1)));
			console.log(html_entity_decode(paginationh));
			pagination.innerHTML=html_entity_decode(paginationh);
			pagination2.innerHTML=html_entity_decode(paginationh);
			
	    }
    }
	
	
    hr.send("folder="+folder+"&pagi="+pagi);
	
	
    thumbnailbox.innerHTML = "requesting...";
}

var notWorking = function(html) {
    var el = document.createElement('div');
    el.innerHTML = html;
    return el.childNodes[0];
	
}

function putinframe(src){
	var pictureframe = document.getElementById("pictureframe");
	pictureframe.innerHTML = '<img src="'+src+'">';
}

</script>


  
  <div class="container">
    	<h3>Album</h3>
		
		
		<div class="row" style="float:left;width: 30%;">
				<p>
					
					<a href="index.php?page=album&action=create_multiple" class="btn btn-success">Ajouter</a>
					
				</p>
				
				<div id="pagination" ></div>
		<table class="table table-striped table-bordered" style="  ">
		 <thead>
		                <tr>
						  <th>Id</th>
						  <th>Image</th>
		                  <th>Action</th>
		                </tr>
		 </thead>
		 <tbody id="thumbnailbox">
			
		 </tbody>
		 </table>
		 <div id="pagination2" ></div>
		 </div>
		
		<div id="pictureframe"></div>
		
		<script>ajax_json_gallery('albums',0);</script>
		
		
		
</div>


