<?php

function getInfoFromSearch($luceneOut){	
	
	$fileinfo = array();
	$searchDocInfo = array();
	$counter = 0;
	
	foreach ($luceneOut as $file){
		
		$fileinfo = explode(",", $file);
		
		if ($counter!=0){
			for ($s = 0 ; $s < sizeof($fileinfo); $s++){
				
				// store into array 1
				//$fileinfo1[$counter][$s] = $fileinfo[$s];
				
				// store into array 2 with index string name
				if ($s == 0)
				$searchDocInfo[$counter]['name'] = $fileinfo[$s];
				elseif ($s == 1)
				$searchDocInfo[$counter]['segmentID'] = $fileinfo[$s];
				elseif ($s == 2)
				$searchDocInfo[$counter]['speakerID'] = $fileinfo[$s];
				elseif ($s == 3)
				$searchDocInfo[$counter]['sentenceID'] = $fileinfo[$s];
				elseif ($s == 4)
				$searchDocInfo[$counter]['startTime'] = $fileinfo[$s];
			}
		}
		$counter++;	
	}
	$counter=0;
	
	return $searchDocInfo;
}