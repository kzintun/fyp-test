<?php  
	function extractMatchListFromArray($finalResultArray){

		$matchList = array();
		foreach($finalResultArray as $key => $value) {
			$matchList[$key] = array();
			foreach ($value as $key2) {
				//foreach ($key2 as $key3) {
				//echo $key2['segmentID'];
				array_push($matchList[$key], $key2['segmentID']);
			}
		//}
		}
		//print_r($matchList);
		return $matchList;
	}
?>
