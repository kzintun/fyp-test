<?php

// retrieve values from simplexml objects into array
// return associative array with numerical index


function getInfoFromConceptSearch($xmlOut){

	$searchDocInfo = array();
	$counter = 0;

 foreach ($xmlOut as $key => $value){
	
		$searchDocInfo[$counter]['docname'] = (string)$value['docName'];
		$searchDocInfo[$counter]['segmentID'] = (string)$value['segID'];
		$searchDocInfo[$counter]['speakerID'] = (string)$value['spkID'];
		$searchDocInfo[$counter]['sentenceID'] = (string)$value['senID'];
		$searchDocInfo[$counter]['startTime'] = (string)$value['startWID'];
		$searchDocInfo[$counter]['text'] = (string)$value['text'];
		$searchDocInfo[$counter]['word'] = "";

		$counter++;	
 }
	return $searchDocInfo;
}

?>