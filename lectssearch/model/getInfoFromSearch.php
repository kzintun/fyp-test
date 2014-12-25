<?php


//	Description: Extract information from lucene search result
//	input = Lucene search result stored in array 
//	output = 2-D array of search result array[index]['*usefulinfo']
//	*usefulinfo= document name, segementID, sentenceID, start time/wordID, text
//	need to reorganize by database in case of search in multiple databases

/* function getInfoFromSearch($luceneOut){	
	$fileinfo = array();
	$searchDocInfo = array();
	$counter = 0;
	foreach ($luceneOut as $file){
		$fileinfo = explode(",", $file);
		
		$docName 	= $fileinfo[0];
		$segId 		= $fileinfo[1];		
		$sentenceId= $fileinfo[3];		
		
		$searchDocInfo[$docName][ (int) $segId ][(int) $sentenceId]['speakerId'] = $fileinfo[2];
		$searchDocInfo[$docName][ (int) $segId ][(int) $sentenceId]['startTime'] = $fileinfo[4];
		$d[$docName][ (int) $segId ][(int) $sentenceId]['text'] = $fileinfo[5];
		asort($searchDocInfo[$docName]);
	}	
	return $searchDocInfo;
}
 */
 

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
				$searchDocInfo[$counter-1]['docname'] = $fileinfo[0];		
				$searchDocInfo[$counter-1]['segmentID'] = $fileinfo[1];		
				$searchDocInfo[$counter-1]['speakerID'] = $fileinfo[2];			
				$searchDocInfo[$counter-1]['sentenceID'] = $fileinfo[3];			
				$searchDocInfo[$counter-1]['startTime'] = $fileinfo[4];			
				$searchDocInfo[$counter-1]['text'] = $fileinfo[5];
				$searchDocInfo[$counter-1]['word'] = "";			
		}
		$counter++;	
	}
	$counter=0;
	
	return $searchDocInfo;
}