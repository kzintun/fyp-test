<!--Version 1.0 created on 30/09/2014 by JH-->
<?php 
session_start();
//session_unset();
//$docInfo = array();

if (!isset($_GET) OR empty($_GET)){
	//list all XML files
	$dir='./database';
	$extension='.xml';
	include_once('controller/listDatabase.php');
}
elseif ( isset($_GET['document']) ){
	//~ one xml file selected - load the xml object and show info
	$document=$_GET['document'];
	//echo $document;
	$selected = $_SESSION['docInfo'][$document];
	//print_r($selected);
	//~ $v = $_SESSION['xml'];
	//~ $xml = new DOMDocument();
	//~ $xml ->loadXML($v);
	//$xml = $_SESSION['xml'] ;
	include_once ('model/loadXML.php');
	//echo $docInfo;

	$docLoc = $selected['xmlLoc'];
	//echo $docLoc;
	$xml = loadXML($docLoc);
	//$xml = new SimpleXMLElement($_SESSION['xml']);
	//~ $xml= new simplexml_load_string($_SESSION['xml']);
	include_once('controller/showDocument.php');
	
}
elseif (isset($_POST['go'])){ 
	if(preg_match("/[A-Z  | a-z]+/", $_POST['searchfield'])){ 
		$keyword=$_POST['searchfield']; 
		echo "This search query, ".$keyword." would be passed to lucene.";
		//include_once("controller/searchLucene.php");
	}
	else {
		
		$errorMessage="Please enter a search query!";
		include_once("view/errorFile.php");
	
	}
}

elseif ( isset($_GET['database']) ){
	//~ one xml file selected - load the xml object and show info
	$xmlFile=$_GET['database'];
	$xmlFile='./database/'.$xmlFile.'.xml';
	//echo $xmlFile;
	include_once('controller/loadDatabase.php');
}











?>
