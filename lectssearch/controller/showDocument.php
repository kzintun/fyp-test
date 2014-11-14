<?php

$document=$_GET['document'];
$database =$_GET['database'];
//$selected = $_SESSION['docInfo'][(String)$document];


if (isset($document)){
	
	$xmlLoc = './databaseOut/'.$document.'.xml';
	if (file_exists($xmlLoc)){	

		include_once("model/loadDatabase.php");		
		$xml=loadDatabase($xmlLoc);
		$_SESSION['xml'] = $xml->asXML();
		
		include_once("model/getMetadataFromXml.php");
		$docInfo = getMetadataFromXml($xml);
		$selected = $docInfo[(String)$document];
	}
	
	//include_once ('model/loadXML.php');
	//$docLoc = $selected['xmlLoc'];
	//$xml = loadXML($docLoc);
	
	include_once("model/loadTranscript.php");
	//print_r($xml);
	$transcript = loadTranscript($xml);
	
	
	/* echo '<pre>';
	print_r($transcript);
	echo '</br>'; */
	
	include_once("model/prepareTranscript.php");
	$printScript = prepTranscript($transcript, $selected, $document);
	
	/* echo '<pre>';
	print_r($printScript);
	echo '</br>'; */
	
	if ($transcript === 0) {
		$errorMessage="Something is wrong with your transcript";
		include_once("view/errorFile.php");
	
	}
	
	else {
		//include_once("view/testTrans.php");
		include_once("view/displayContent.php");
	}
	
	
	
}	
else{
	$errorMessage="problem with document entry";
	include_once('view/errorFile.php');
}

