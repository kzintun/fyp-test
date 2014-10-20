<?php


//	Description: Extract information from lucene search result
//	input = Lucene search result stored in array 
//	output = 2-D array of search result array[index]['*usefulinfo']
//			*usefulinfo= document name, segementID, sentenceID, start time/wordID, text

function getInfoFromSearch($luceneOut){	
	
	$fileinfo = array();
	$searchDocInfo = array();
	$counter = 0;
	
	foreach ($luceneOut as $file){
		
		$fileinfo = explode(",", $file);
		
		if ($counter!=0){
			for ($s = 0 ; $s < sizeof($fileinfo); $s++){
	
				if ($s == 0)
				$searchDocInfo[$counter-1]['docname'] = $fileinfo[$s];
				elseif ($s == 1)
				$searchDocInfo[$counter-1]['segmentID'] = $fileinfo[$s];
				elseif ($s == 2)
				$searchDocInfo[$counter-1]['speakerID'] = $fileinfo[$s];
				elseif ($s == 3)
				$searchDocInfo[$counter-1]['sentenceID'] = $fileinfo[$s];
				elseif ($s == 4)
				$searchDocInfo[$counter-1]['startTime'] = $fileinfo[$s];
				elseif ($s == 5)
				$searchDocInfo[$counter-1]['text'] = $fileinfo[$s];
			}
		}
		$counter++;	
	}
	$counter=0;
	
	return $searchDocInfo;
}