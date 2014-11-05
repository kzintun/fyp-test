<?php 

function loadTranscript($xml) {
	include_once("model/getXMLAttribute.php");

	//print_r($xml);
	$transcript = array();
	
	$segmentNode = array('id','spkName','startTime','endTime');
	$sentenceNode = array('id','spkName','startTime','endTime');
	$wordNode = array('id','spkName','startTime','endTime');

	
	foreach ($xml->document->content->segment as $seg) {
		
		$segment = array();
		
		// Set Segment Info Data
		$segmentInfo = array();
		for ($a=0; $a<sizeof($segmentNode); $a++) {
			
			if (isset($seg->attributes()->$segmentNode[$a])) {
				$segmentInfo[$segmentNode[$a]] = xml_attribute($seg, $segmentNode[$a]);
				//$test = xml_attribute($seg, $segmentNode[$a]);
				//print $test;

			}
			else {
				return -1;
			}
			
		}
		//print_r ($segmentInfo); 
		$segmentID = (string) $segmentInfo['id'];
		$segment['segInfo'] = $segmentInfo;
	
		// Set Sentences
		foreach ($seg->sentence as $sen) {
			//print_r($sen);
			$sentence = array();
			
			// Set Sentence Info Data
			$sentenceInfo = array();
			for ($a=0; $a<sizeof($sentenceNode); $a++) {
				if (isset($sen->attributes()->$sentenceNode[$a])) {
					$sentenceInfo[$sentenceNode[$a]] = xml_attribute($sen, $sentenceNode[$a]);
				}
				else {
					return -1;
					//$segment[$sentenceNode[$a]] = "N.A.";
				}
			}
			
			$senID = (string) $sentenceInfo['id'];
			$sentence['senInfo'] = $sentenceInfo;
			
			// Set Words
			//$words = array();
			foreach ($sen->word as $wd) {
				//print_r($wd);
				$word = array();
				$wordInfo = array();
				for ($a=0; $a<sizeof($wordNode); $a++) {
					if (isset($wd->attributes()->$wordNode[$a])) {
						$wordInfo[$wordNode[$a]] = xml_attribute($wd, $wordNode[$a]);
					}
					else {
						return -1;
					}
				}
				
				$wordID = (string) $wordInfo['id'];
				$word['wordInfo'] = $wordInfo;
				$word['word'] = $wd->asXml();				
				$sentence[$wordID] = $word;
				//print_r($word);
			}
			
			$segment[$senID] = $sentence; 
		}
		$transcript[$segmentID] = $segment;	
	}
	
	
	return $transcript;
}

