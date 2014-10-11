<!--Version 1.0 created on 12/10/2014 by JH-->

<?php
session_start();

if(isset($_POST['go'])){ 
	if(preg_match("/[A-Z  | a-z]+/", $_POST['searchfield'])){ 
		$name=$_POST['searchfield']; 
		echo "This search query, ".$name." would be passed to lucene.";
		//include_once("controller/searchLucene.php");
	}
	else {
		
		$errorMessage="Please enter a search query!";
		include_once("view/errorFile.php");
	
	}
}
