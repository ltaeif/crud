<?php
require 'config.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<html  dir="rtl" lang="ar" xml:lang="ar" xmlns="http://www.w3.org/1999/xhtml">-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /> 
    
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/styles.css" rel="stylesheet" media="screen">          
		
		<script type="text/javascript" src="bootstrap/ajax-image-upload/js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="bootstrap/ajax-image-upload/js/jquery.form.min.js"></script>
		<script src="bootstrap/bootstrap-paginator/src/bootstrap-paginator.js"></script>
		<script src="bootstrap/bootstrap-paginator/lib/qunit-1.11.0.js"></script>
		<script src="bootstrap/tools.js"></script>

    <script type="text/javascript" src="bootstrap/jquery/dist/jquery.js"></script>
		
		<link href="bootstrap/ajax-image-upload/style/style.css" rel="stylesheet" type="text/css">






	
</head>

<body>
	
	<div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="../">Admin Panel</a>
                    <div class="nav-collapse collapse">
                      
                        <ul class="nav">
                            <li class="active">
                               <!-- <a href="index.php?lan=an">FREE SIGHT ASSOCIATION - جمعية رؤية حرة</a>-->
                            </li>   <li class="">
                                <a href="index.php?lan=an">accueil</a>
                            </li>
                          </ul>
						  						    <ul class="nav pull-right">
                            <li class="">
                                <a href="?page=ajoute&&lan=an"><img src="icon/an.png" width="20px" height="20px"  ></a>
                            </li>   
							
							<li class="">
                                <a href="?page=ajoute&lan=fr"><img src="icon/fr.png" width="20px" height="20px"  ></a>
                            </li>
                          </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>	

    <div class="container">
	
			<div class="row-fluid">
			
			<div class="span3" id="sidebar">
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                        <li class="active">
                            <a href="index.php?lan=an"><i class="icon-chevron-right"></i> accueil</a>
                        </li>
						
						
						<li>
                             <a href="?page=projet&action=index"><i class="icon-chevron-right"></i> Listes des Projets et activités</a>
                        </li>
						
						
						
						<li>
                            <a href="?page=presse&action=index"><i class="icon-chevron-right"></i> Liste des articles presse</a>
                        </li>
						
							<li>
                             <a href="?page=album&action=index"><i class="icon-chevron-right"></i> Album</a>
                        </li>
						
                    </ul>
			</div>
            
			
		<div class="span9" id="content">
				
				<?php
				//echo _ASS_ROOT_DIR_.'/views/'.$_GET['page'].'/'.$_GET['action'].'.php';
				//echo '/views/'.$_GET['page'].'/'.$_GET['action'].'.php';
					if(isset($_GET['page']) && file_exists(_ASS_ROOT_DIR_.'/views/'.$_GET['page'].'/'.$_GET['action'].'.php'))
					
					{
					//echo '/views/'.$_GET['page'].'/'.$_GET['action'].'.php';
					include(dirname(__FILE__).'/views/'.$_GET['page'].'/'.$_GET['action'].'.php');
					
					}
					
					//include('/views/'.$_GET['page'].'/'.$_GET['action'].'.php');
					
				?>
				
				
		</div> <!-- 
			
			
			
			
			
			
			</div> <!-- Row Fluid -->
    </div> <!-- /container -->
  </body>
</html>