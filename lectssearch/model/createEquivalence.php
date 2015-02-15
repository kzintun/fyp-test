<?php  
function createEquivalence($printScript){
	$equivalence = array();
	$equivalence = $printScript[0]['eq'];
	if(count($printScript)>1) {
		for ($i = 1; $i < count($printScript); $i++) {
			$equivalence = array_merge($equivalence, $printScript[$i]['eq']);
		}
	}
	
	
	//print_r($equivalence);

	return $equivalence;
}
?>