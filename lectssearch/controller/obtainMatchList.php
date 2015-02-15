<?php

$document=html_entity_decode($_POST['document']);
$database =html_entity_decode($_POST['database']);
$matches = json_decode($_POST['matches'],true);

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
		if  (isset($matches)) {
			include_once("model/getMatchList.php");

			$matchList = getMatchList($printScript[0]['eq'], $matches);
		}
		else{
			$matchList = array();
		}
		echo json_encode($matchList);
	}
}
