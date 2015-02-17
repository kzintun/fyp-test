<?php

// input = subject array 
// output = subject array with concept keywords bold
// highlight the keywords
function highlightConcept($haystackArray) {
	
	//echo '<pre>';
	//for ($k=0 ; $k < sizeof($haystackArray); $k++){
	foreach ($haystackArray as $key => $hay){
	
		$wordArry = explode(" ", $hay['text']);
		$startWIndex = $hay['swID'];
		$endWIndex = $hay['ewID'];
		
		//echo $startWIndex . ' - ' . $endWIndex .'<br>';
		//print_r($wordArry);
		
		for ($i=$startWIndex; $i<= $endWIndex ; $i++){
			$wordArry[$i] = '<b>'.$wordArry[$i].' </b>';
			//echo $wordArry[$i] .' ';
		}
		$haystackArray[$key]['text'] = implode(" ",$wordArry);
		//echo $hay['text'] . ' ';
	}
	//echo '</pre>';
    return $haystackArray;
}
?>