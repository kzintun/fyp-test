<!--Version 1.0 created on 30/09/2014 by JH-->
<?php 
session_start();

if (!isset($_GET) OR empty($_GET)){
	//list all XML files
	$dir='./database';
	$extension='.xml';
	include_once('controller/listDatabase.php');
}
elseif ( isset($_GET['database']) ){
	//~ one xml file selected - load the xml object and show info
	$xmlFile=$_GET['database'];
	//echo $xmlFile;
	include_once('controller/loadDatabase.php');
}
elseif ( isset($_GET['document']) ){
	//~ one xml file selected - load the xml object and show info
	$document=$_GET['document'];
	//~ $v = $_SESSION['xml'];
	//~ $xml = new DOMDocument();
	//~ $xml ->loadXML($v);
	//$xml = $_SESSION['xml'] ;
	$xml = new SimpleXMLElement($_SESSION['xml']);
	//~ $xml= new simplexml_load_string($_SESSION['xml']);
	include_once('controller/showDocument.php');
	
}











?>
