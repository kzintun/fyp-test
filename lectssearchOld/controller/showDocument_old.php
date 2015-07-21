<?php

$document=$_GET['document'];
$database =$_GET['database'];
$selected = $_SESSION['docInfo'][(String)$document];


if (isset($document)){
	

	/*note to self
	model -> load the entire content of xml from docdir into docTrans
	model -> load meta info of xml into an array
	view -> load the .wav file from data folder
	view -> load docTrans into transcription tab
	view -> load description in array into description tab
	view -> unset previous entry in array(docInfo) for current video
	view -> display other entries in docInfo at bottom of the page 
	
	*/
	
	include_once ('model/loadXML.php');
	$docLoc = $selected['xmlLoc'];
	$xml = loadXML($docLoc);

	include_once("model/loadTranscript.php");
	//print_r($xml);
	$transcript = loadTranscript($xml);
	
	include_once("model/prepareTranscript.php");
	$printScript = prepTranscript($transcript);
	
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

