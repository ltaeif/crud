<?php
require('UploadHandler.php');

class CustomUploadHandler extends UploadHandler {
	
	function __construct($options = null, $initialize = true, $error_messages = null,$newdirectories= array('upload_dir'=>'/files/','urlapp'=>'/files/')) {
	    parent::__construct($options,$initialize,$error_messages,$newdirectories);
	  }
    protected function initialize() {
        $this->db = new mysqli(
            $this->options['db_host'],
            $this->options['db_user'],
            $this->options['db_pass'],
            $this->options['db_name']
			
        );
	
			
        parent::initialize();
        $this->db->close();
    }

    protected function handle_form_data($file, $index) {
        $file->title = @$_REQUEST['title'][$index];
        $file->description = @$_REQUEST['description'][$index];
    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error,
            $index = null, $content_range = null) {
        $file = parent::handle_file_upload(
            $uploaded_file, $name, $size, $type, $error, $index, $content_range
        );
        if (empty($file->error)) {
            $sql = 'INSERT INTO `'.$this->options['db_table']
                .'` (`name`, `size`, `type`, `title`, `description`)'
                .' VALUES (?, ?, ?, ?, ?)';
            $query = $this->db->prepare($sql);
            $query->bind_param(
                'sisss',
                $file->name,
                $file->size,
                $file->type,
                $file->title,
                $file->description
            );
            $query->execute();
			
			
			
            $file->id = $this->db->insert_id;
        }
        return $file;
    }

    protected function set_additional_file_properties($file) {
        parent::set_additional_file_properties($file);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $sql = 'SELECT `id`, `type`, `title`, `description` FROM `'
                .$this->options['db_table'].'` WHERE `name`=?';
            $query = $this->db->prepare($sql);
            $query->bind_param('s', $file->name);
            $query->execute();
            $query->bind_result(
                $id,
                $type,
                $title,
                $description
            );
            while ($query->fetch()) {
                $file->id = $id;
                $file->type = $type;
                $file->title = $title;
                $file->description = $description;
            }
        }
    }

    public function delete($print_response = true) {
        $response = parent::delete(false);
        foreach ($response as $name => $deleted) {
            if ($deleted) {
                $sql = 'DELETE FROM `'
                    .$this->options['db_table'].'` WHERE `name`=?';
                $query = $this->db->prepare($sql);
                $query->bind_param('s', $name);
                $query->execute();
            }
        } 
        return $this->generate_response($response, $print_response);
    }

    
		
	function recurse_copy($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
               $this->recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
	} 
	
	function rmdir_recursive($dir)
		{
		 //Liste le contenu du répertoire dans un tableau
		 $dir_content = scandir($dir);
		 //Est-ce bien un répertoire?
		 if($dir_content !== FALSE){
		  //Pour chaque entrée du répertoire
		  foreach ($dir_content as $entry)
		  {
		   //Raccourcis symboliques sous Unix, on passe
		   if(!in_array($entry, array('.','..'))){
			//On retrouve le chemin par rapport au début
			$entry = $dir . '/' . $entry;
			//Cette entrée n'est pas un dossier: on l'efface
			if(!is_dir($entry)){
			 unlink($entry);
			}
			//Cette entrée est un dossier, on recommence sur ce dossier
			else{
			 $this->rmdir_recursive($entry);
			}
		   }
		  }
		 }
		 //On a bien effacé toutes les entrées du dossier, on peut à présent l'effacer
		 rmdir($dir);
		}

}