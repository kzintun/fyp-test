<?php

if (isset($document)){
	//print $document . "</br>";
	// model does nothing !! youpi !!
	//include_once("model/populateXML.php");		
	// in the future, the odel will be able to analyse keywords for instance
	//$xml->asXML();
	//echo $xml->asXML();

	/*note to self
	model -> load the entire content of xml from docdir into docTrans
	model -> load meta info of xml into an array
	view -> load the .wav file from data folder
	view -> load docTrans into transcription tab
	view -> load description in array into description tab
	view -> unset previous entry in array(docInfo) for current video
	view -> display other entries in docInfo at bottom of the page 
	
	*/
	
	// the view is a three level loop?
	include_once("view/displayContent.php");
	
}	
else{
	$errorMessage="problem with docuement entry";
	include_once('view/errorFile.php');
}

