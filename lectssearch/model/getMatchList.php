<?php 
function getMatchList($equivalence, $searchResult){
	//print_r($equivalence);
	$output = array();
	//print_r($output);
	
	foreach($searchResult as $spkTurnId){
		foreach($spkTurnId['results'] as $keySeg => $value){
			foreach($spkTurnId['results'][$keySeg] as $keySent => $value2){
				//~ echo "$keySeg,$keySent\n";
				$keyEq = (string)$keySeg . ',' . (string)$keySent;
				//~ echo $equivalence[$keyEq]. "\n";
				$output[] = $equivalence[$keyEq];
		//~ foreach($searchResult[$spkTurnId]['results'] as $key1 => $value){
			//~ foreach ($searchResult[$spkTurnId]['results'][$key1] as $key2 => $value1){
				//~ echo "$key1 \n";
			}
		}
	}
			
			
	//print_r($output);
	return $output;
}
