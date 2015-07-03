
<script type="text/javascript">

$(document).ready(function() { 



$("#ville option").each(function(index){
           
		  
		  	$.ajax({
			   url : 'process.php', // La ressource ciblée
			   data : 'ville='+$(this).val(),
			   type : 'GET', // Le type de la requête HTTP.
			   success : function(data){ // code_html contient le HTML renvoyé
					//console.log(data);
					}
				});
				
				
        });  
		
		
	


}); 	
	</script>
	
	<select style="width:150px" name="ville" class="champs_parcourir" id="ville"><option value="Ariana" cid="0">Ariana</option><option value="Beja" cid="1">Beja</option><option value="Ben Arous" cid="2">Ben Arous</option><option value="Bizerte" cid="3">Bizerte</option><option value="Gabes" cid="4">Gabes</option><option value="Gafsa" cid="5">Gafsa</option><option value="Jendouba" cid="6">Jendouba</option><option value="Kairouan" cid="7">Kairouan</option><option value="Kasserine" cid="8">Kasserine</option><option value="Kebili" cid="9">Kebili</option><option value="Kef" cid="10">Kef</option><option value="Mahdia" cid="11">Mahdia</option><option value="Mannouba" cid="12">Mannouba</option><option value="Medenine" cid="13">Medenine</option><option value="Monastir" cid="14">Monastir</option><option value="Nabeul" cid="15">Nabeul</option><option value="Sfax" cid="16">Sfax</option><option value="Sidi Bouzid" cid="17">Sidi Bouzid</option><option value="Siliana" cid="18">Siliana</option><option value="Sousse" cid="19">Sousse</option><option value="Tataouine" cid="20">Tataouine</option><option value="Tozeur" cid="21">Tozeur</option><option value="Tunis" cid="22">Tunis</option><option value="Zaghouan" cid="23">Zaghouan</option></select>