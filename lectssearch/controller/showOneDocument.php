<?php

$document=$_GET['document'];
$database =$_GET['database'];

if (isset($document)){	
	$xmlLoc = './documents/'.$document.'.xml';
	
	if (file_exists($xmlLoc)){	
		
		//  TODO session variable with xmlDocumentContent
		// => to prevent loading twice in a session
		//~ $_SESSION['xml'] = $xml->asXML();
		
		include_once("model/loadXML.php");
		//~ $xml=loadXMLFile($xmlLoc);
		$xml=loadXML($xmlLoc);
		
		 //~ metada and transcription should come together.
		include_once("model/getMetadataFromXmlDocument.php");
		$docInfo = getMetadataFromXmlDocument($xml);
		
		//~ TODO: add a session variable	with the transcript
		include_once("model/loadTranscript.php");
		$transcript = loadTranscript($xml);
		
		include_once("model/prepareSegTranscript.php");
		$printScript = prepSegTranscript($transcript, $docInfo , $document);
		
		//print_r($printScript);
		// need to preprare also the text for the description. (no loop in the view)
	
		if ($transcript === 0) {
			$errorMessage="Something is wrong with your transcript";
			include_once("view/errorFile.php");
		}
		else {
			//include_once("view/testTrans.php");
			// big problem in the management of the display.
			 //echo $docInfo['media'] ;
			  //echo $docInfo['type'];
			include_once("view/displayContent.php");
		}
	}	
	else{
		$errorMessage="problem with document entry";
		include_once('view/errorFile.php');
	}
}
