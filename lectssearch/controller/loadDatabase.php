<?php

//~ check if the variable is set
//echo $xmlFile ;

	$xmlFile=$_GET['database'];
	$xmlFile='./database/'.$xmlFile.'.xml';
	
if (file_exists($xmlFile)){	

	include_once("model/loadDatabase.php");		
	$xml=loadDatabase($xmlFile);
	$_SESSION['xml'] = $xml->asXML();
	 
	if ($xml === 0 ){
		//print $xml;
		$errorMessage="Problem while loading $xmlFile";
		include_once("view/errorFile.php");
	}
	
	else{
		//remove need to transverse thru each doc
		//include_once("model/getInfoFromDocList.php");
		//$docInfo=getInfoFromDocList($docList);
		
		//new method to read metadata directly from xml
		include_once("model/getMetadataFromXml.php");
		$docInfo=getMetaDataFromXml($xml);
		
		$_SESSION['docInfo'] = $docInfo;
		//~ show doc in a table
		include_once("view/displayAllXML.php");
	}	
}
else{
	$errorMessage="Path to XML file not set";
	include_once("view/errorFile.php");
}

