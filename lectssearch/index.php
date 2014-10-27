<!--Version 1.0 created on 30/09/2014 by JH-->
<?php 
session_start();
//session_unset();
//$docInfo = array();


//	Scenario 1
if (!isset($_GET) OR empty($_GET)){
	//list all XML files
	include_once('controller/listDatabase.php');
}

//	Scenario 2
elseif ( isset($_GET['database']) AND  (!isset($_GET['document']) OR empty($_GET['document'])) AND !isset($_POST['go']) ){
	//~ one xml file selected - load the xml object and show info
	
	//echo $xmlFile;
	include_once('controller/loadDatabase.php');
}

//	Scenario 3
elseif ( isset($_GET['document'])  AND  isset($_GET['database']) ){
	//~ one xml file selected - load the xml object and show info
	include_once('controller/showDocument.php');
	
}

//	Scenario 4
elseif (isset($_POST['go'])){ 
	if(preg_match("/[A-Z  | a-z]+/", $_POST['searchfield'])){ 
		 
		//echo "This search query, ".$keyword." would be passed to lucene.";
		//include_once('controller/keywordSearch.php');
		include_once('controller/searchKeyword.php');
	}
	else {
		
		$errorMessage="Please enter a search query!";
		include_once("view/errorFile.php");
	
	}
}













?>
