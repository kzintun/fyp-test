<?php

function prepTranscript($transcriptArray, $docInfo) {

	//$transcriptString = '<p align="justify" style="text-align:justify">' ;
	$transcriptString = " " ;
	$speakers = explode(",",$docInfo['speaker']);
	
	foreach ($transcriptArray as $segment) 
	{
		$numSen = count($segment);
		if ($numSen <= 1) continue;
 
		$spkID = (int) $segment["segInfo"]["spkName"];
		$speaker = (string) $speakers[$spkID];  
		
		$transcriptString .= "<b>".$speaker.": </b>";
		foreach ($segment as $a=>$sentence) {
			$numWords = count($sentence);
			if ($numWords <= 1) continue; //if no actual sentence exist
			$index = 0;
			foreach ($sentence as $b=>$words) {
				
				if (isset($words["word"])) {
					$index = $index + 1;
					$word = $words["word"];	
					
					if (isset($words["wordInfo"]["startTime"])) {
						$time = (string)$words["wordInfo"]["startTime"];
						$transcriptString .= '<a href="#video44" style="text-decoration:none; onclick="jwplayer().seek('.$time.');">'.$word.'</a> ';
					}
					else {
						$transcriptString .= $word;

					}
					//don't add space for last word -not working
					if($index < ($numWords-2)) {
					 	$transcriptString .= " ";
					}
				}
			}
			if(is_numeric($a)){
				$transcriptString .= ". ";
			}
				
		}
		//$transcriptString .= "</p>";
		$transcriptString .= "<br>";
	}

	return $transcriptString;

}