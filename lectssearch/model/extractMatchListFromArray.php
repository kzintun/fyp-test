<?php  
	function extractMatchListFromArray($finalResultArray){

		$matchList = array();
		foreach($finalResultArray as $key => $value) {
			$matchList[$key] = array();
			$matchList[$key]['results'] = array();
			//$spkerList = array();
			foreach ($value as $key2) {
				//foreach ($key2 as $key3) {
				//echo $key2['segmentID'];
				$segList = array();
				$segID = $key2['segmentID'];
				$senID = $key2['sentenceID'];
				$text = $key2['text'];
				//$spkerID = $key2['speakerID'];
				//if(!(isset($matchList[$key][$spkerID]['results'])) {
				//	$matchList[$key]['results'][$spkerID] = array();
				//}

				if(!(isset($matchList[$key]['results'][$segID]))) {
					$matchList[$key]['results'][$segID] = array();
				}
				if(!(isset($matchList[$key]['results'][$segID][$senID]))) {
					$matchList[$key]['results'][$segID][$senID] = array();
				}
				//array_push($matchList[$key]['results'][$segID], $senID);

				//$matchList[$key]['results'][$segID][$senID]['text'] = $text;
				//array_push($matchList[$key], $key2['segmentID']);
			}
		//}
		}
		//print_r($matchList);
		return $matchList;
	}
?>
