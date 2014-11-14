<?php

function prepTranscript($transcriptArray, $docInfo, $docuName) {

	//$transcriptString = '<p align="justify" style="text-align:justify">' ;
	$transcriptString = " " ;
	$speakers = explode(",",$docInfo['speaker']);
	//$docuName = key($docInfo);
	$colorCode = '#000000';
	$highlightWord = 'focus find search Lakota space'; 
	//$_SESSION['searchWord'];
	$wList = explode(' ',$highlightWord);
	//echo '<pre>';
	//print_r($wList);
	foreach ($transcriptArray as $segment) 
	{
		$numSen = count($segment);
		if ($numSen <= 1) continue;
 
		$spkID = (int) $segment["segInfo"]["spkName"];
		$speaker = (string) $speakers[$spkID];  
		
		$transcriptString .= "<b><font color='blue'>".$speaker.": </font></b>";
		foreach ($segment as $a=>$sentence) {
			
			$numWords = count($sentence);
			if ($numWords <= 1) continue; //if no actual sentence exist
			$index = 0;
			foreach ($sentence as $b=>$words) {
				
				if (isset($words["word"])) {
					
					$index = $index + 1;
					$word = (string)$words["word"];	
					
					if (isset($words["wordInfo"]["startTime"])) {
						$time = round($words["wordInfo"]["startTime"]); // convert float to integer
						
						$b = (string) $word;						
						//echo '<pre>';
						//print_r($highlightWord);
						
						/* 
						echo is_string($b). ' '. $b . '<br>';
						echo is_string($highlightWord). ' '. $highlightWord . '<br>'; */
						//echo gettype($highlightWord) .'<br>';
						
						//echo $highlightWord .' and '. $word .' and '. $pos .'<br>';
						
						
						/* if (strpos($highlightWord,$word) !== false){
							echo 'true <br>';
							$colorCode = '#00FF00';
						}
						
						if (preg_match("/\b$word+\b/i",$highlightWord)){
							$colorCode = '#00FF00';
						} */
						
						foreach ($wList as $ww)
						{
						//echo gettype($ww);
						/* var_dump($ww);
						echo '<br>';
						var_dump($word);
						echo '<br>'; */
						
						if ($ww === $word)
						{
							echo 'words are equal';
						}
						//echo '<br>';
						//echo '<br> Comparing: '.$ww . ' with :'. $word. '<br>' ;
						if (strcasecmp(trim($ww), trim($word)) == 0){
							echo 'two words are equal';
							$colorCode = '#00FF00';
							}
						}
						
						//$transcriptString .= '<a href="#video44" style="color: #000000" onclick="jwplayer(0).seek('.$time.');">'.$word.'</a> ';
						$transcriptString .= '<a href="#video44" style="color: '.$colorCode.'" onclick="jwplayer(0).seek('.$time.');">'.$word.'</a> ';
						$colorCode = '#000000';
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