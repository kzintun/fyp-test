<?php

$database =$_GET['database'];
$xmlFile='./collections/'.$database.'.xml';
$errorMessage = null;
$docInfo = 0;
	
if (file_exists($xmlFile)){		

	include_once("model/loadXML.php");		
	$xml=loadXML($xmlFile);
	//~ $xml=loadCollectionXML($xmlFile);

	// TODO: preprare a session variable with the collections
	// to prevent loading the database again.
		 
	if ($xml === 0 ){		
		$errorMessage="Problem while loading $xmlFile";
		include_once("view/errorFile.php");
	}
	else{		
		include_once("model/getMetadataFromXmlCollection.php");
		//~ $docInfo=compileMetadataCollectionXml($xml);		
		$docInfo=getMetaDataFromXmlCollection($xml);		
		
		// see later for session variable.
		//~ $_SESSION['docInfo'] = $docInfo;
		include_once("model/calConceptToDoc.php");
		$treeTable=calculateConcepts($database);

		if ($docInfo != 0 ){
			include_once("view/displayAllXML.php");
		}
		
		else {
			$errorMessage="Path to XML file not set";
			include_once("view/errorFile.php");
		}		
	}	
}
else if(($docInfo == 0)&&($database == 'all')) {
			$errorMessage="No Search Results Found.";
			//include_once("view/errorFile.php");
			include_once("view/displayAllXML.php");
		}	
else{
	$errorMessage="Path to XML file not set";
	include_once("view/errorFile.php");
}

