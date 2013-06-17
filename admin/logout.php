<?php
	session_start ();	

	if (!isset($_SESSION["name"]) || !isset($_SESSION["mail"])){ 
   		header("Location: index.php");	
	}else{ 

	$_SESSION = array();
      session_destroy ();header("location: index.php");
	}
?>