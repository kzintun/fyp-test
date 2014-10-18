<?php

//~ check if the variable is set
//echo $xmlFile ;

if (file_exists($xmlFile)){
	include_once("model/loadDatabase.php");		
	global $xml;
	$xml=loadDatabase($xmlFile);
	$_SESSION['xml'] = $xml->asXML();
	 
	//~ $xml->formatOutput = true;
	//~ $_SESSION['xml'] =  $xml->saveXML(); 
	//print_r($xml);
		
	if ($xml === 0 ){
		//print $xml;
		$errorMessage="problem while loading $xmlFile";
		include_once("view/errorFile.php");
	}
	else{
		// LIST DOCUMENT AND RETURN $DOCLIST
		include_once("model/getDocListFromXml.php");
		$docList=getDocListFromXml($xml);
		//print_r($docList);
		if ($docList === 0){
			$errorMessage="No document found in the database";
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
}
else{
	$errorMessage="path to databse not set";
	include_once("view/errorFile.php");
}

