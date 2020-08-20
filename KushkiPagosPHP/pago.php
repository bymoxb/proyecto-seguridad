<?php 
 
	if (isset($_GET['action'])) {
		$action=$_GET['action'];
		
	}else{
		$action='init';
    }
 		require_once('masterPage.php');	
 ?>