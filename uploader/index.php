<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

error_reporting(E_ALL | E_STRICT);

require '../database.php';
require('UploadHandler.php');



$dirdemande=(isset($_POST['dirdemande'])  )? $_POST['dirdemande'] : (isset($_GET['dir'])) ? $_GET['dir'] : "";
$urldemande=(isset($_POST['urldemande'])  )? $_POST['urldemande'] : "";


$options = array(
    'delete_type' => "POST",
    'db_host' => "localhost",
    'db_user' => "root",
    'db_pass' => "",
    'db_name' => "association",
    'db_table' => "files",
);



$direc=array(
    'upload_dir'=>'/../'.$dirdemande,
    'urlapp'=>'/../'.$dirdemande);

//print_r($direc);

$upload_handler = new UploadHandler($options,true,null);
