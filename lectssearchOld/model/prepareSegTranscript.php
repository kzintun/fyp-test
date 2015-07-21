<?php

function prepSegTranscript($transcriptArray, $docInfo, $docuName) {
	// input = array of arrays with segment, sentence, and word informations	
	// $transcriptString = '<p align="justify" style="text-align:justify">' ;


	//~ print_r($transcriptArray);

	// shorten unknow speaker name
	foreach($docInfo['speaker'] as &$spk){
		if (preg_match("/unknown_/" , $spk )){
			$spk = (string) "unknown";
		}
	}
		

	// ===========================================================	
	
	$counter = 0;
	$currentSpeaker = 'none';	
	$speakerChange = array();	
	$previousSegmentEnd =(int)  ($transcriptArray[0]['content'][0]['startTime'] * 100);

	// ============================
	// Building table of sentence for display
	// Capturing speaker sections
	// ============================	
	ksort($transcriptArray);	
	$last = array_pop(array_keys($transcriptArray));		

	foreach ( $transcriptArray as $iSeg => $value){ 
		// get speaker changes
		if  (  $currentSpeaker != $transcriptArray[$iSeg]['spkName']){
			$speakerChange[] = $counter;
		}
		if ($iSeg == $last){
			$speakerChange[] = $counter + 1;
		}
		$currentSpeaker = $transcriptArray[$iSeg]['spkName'];
		
		//~ print_r($speakerChange);
		
		// ============================
		ksort($transcriptArray[$iSeg]['content']);	
		foreach($transcriptArray[$iSeg]['content']  as $iSent  => $value ){									
			$sentenceTag = $iSeg . ','. $iSent ;	
			$sentStartTime =  (int)  ($transcriptArray[$iSeg]['content'][$iSent]['startTime'] * 1000);
			$sentEndTime   =  (int)  ($transcriptArray[$iSeg]['content'][$iSent]['endTime'] * 1000);
			$durationTime =  (int) $sentEndTime - (int) $sentStartTime;
			$gapSent	 = $sentStartTime - $previousSegmentEnd;
			if ($gapSent < 0){
				$gapSent = 0;
			}
			$previousSegmentEnd = $sentEndTime;
				
			// ============================			
			$currentLine = array();
			ksort($transcriptArray[$iSeg]['content'][$iSent]['content']);	
			foreach ($transcriptArray[$iSeg]['content'][$iSent]['content']  as $iWord => $value){
				$word = (string)$transcriptArray[$iSeg]['content'][$iSent]['content'][$iWord]['word'];
				$currentLine[] = $word;				
			}
			
			$text = join(' ', $currentLine);
			$text .= '.';
			$text = ucfirst($text);
			$setOfSentences[$counter] = array();
			$setOfSentences[$counter]['text'] = $text;
			$setOfSentences[$counter]['eq'] = $sentenceTag;
			$setOfSentences[$counter]['start'] =  $sentStartTime;
			$setOfSentences[$counter]['duration'] = $durationTime;
			$setOfSentences[$counter]['speaker'] =  $docInfo['speaker'][$currentSpeaker];
			$setOfSentences[$counter]['gap'] =  $gapSent;
			
			$counter++;

		}
	}	
	
	//~ print_r($speakerChange);

	// ===========================================================
	// Preparing text for display and search
	// ===========================================================
	$transcriptString = array();

	for ($idSpkChange = 0 ; $idSpkChange < (count($speakerChange) - 1) ; $idSpkChange++){
		
		// Splice from  $setOfSentences[$speakerChange[$idSpkChange]] to $setOfSentences[$speakerChange[$idSpkChange +1]]
		$offset = $speakerChange[$idSpkChange] ;
		$length = $speakerChange[$idSpkChange + 1 ]  - $speakerChange[$idSpkChange];		
		$currentSlice = array_slice($setOfSentences, $offset , $length ) ;  
	
		//// ================================================ //
		$transcriptString[$idSpkChange]['text'] = '';
		
		for ($idText = 0 ; $idText < count($currentSlice) ; $idText++){
			if (count($currentSlice) == 1){
				$currentSlice[$idText]['prepText']='<p>'."\n".'<span id="'. ($offset + $idText) .'">'.$currentSlice[$idText]['text'] . '</span>'."\n".'</p>'."\n";
			}
			else if ($idText == 0){
				$currentSlice[$idText]['prepText']='<p>'."\n".'<span id="'. ($offset + $idText) .'">'.$currentSlice[$idText]['text'] . '</span>'."\n";
			}			
			else if ( $currentSlice[$idText]['gap'] > 500 ){
				$currentSlice[$idText]['prepText'] = '</p>'."\n".'<p>'."\n".'<span id="'. ( $offset + $idText) .'">'. $currentSlice[$idText]['text'] . '</span>'."\n";				
			}			
			else if ($idText ==  count($currentSlice) -1 ){
				$currentSlice[$idText]['prepText'] = '<span id="'. ( $offset + $idText) .'">'.  $currentSlice[$idText]['text'] . '</span>'."\n".'</p>'."\n"; 
			}
			else{
				$currentSlice[$idText]['prepText']='<span id="'. ($offset + $idText) .'">'.$currentSlice[$idText]['text'] . '</span>'."\n";
			}
			
			$currentSlice[$idText]['prepSpeaker'] =  '<b class="speaker">'. $currentSlice[$idText]['speaker'] . ': </b>';
			
			// === populating the final table == //
			$transcriptString[$idSpkChange]['text'] .= $currentSlice[$idText]['prepText'];
			$transcriptString[$idSpkChange]['speaker'] = $currentSlice[$idText]['prepSpeaker'];
			$transcriptString[$idSpkChange]['table'][] =  $offset + $idText. ',' .$currentSlice[$idText]['start']. ', ' .$currentSlice[$idText]['duration']. ', "' . $currentSlice[$idText]['speaker']. '", "MS", "'. $currentSlice[$idText]['text'].'"';			
			$transcriptString[$idSpkChange]['eq'][$currentSlice[$idText]['eq']]  = $idText + $offset;
		}
	}
	
	// print_r($transcriptString);
	return $transcriptString;
}
