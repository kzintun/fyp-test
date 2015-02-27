<?php

// input = subject array 
// output = subject array with concept keywords bold
// highlight the keywords
function highlightConcept($haystackArray) {
	
	echo '<pre>';
	//for ($k=0 ; $k < sizeof($haystackArray); $k++){
	foreach ($haystackArray as $key => $hay){
	
		$wordArry = explode(" ", $hay['text']);
		$startWIndex = $hay['swID'];
		$endWIndex = $hay['ewID'];
		
		//echo $startWIndex . ' - ' . $endWIndex .'<br>';
		//print_r($wordArry);
		
		for ($i=$startWIndex; $i<= $endWIndex ; $i++){
			$wordArry[$i] = '<b>'.$wordArry[$i].'</b>';
		//	$wordArry[$i] = '<b> '.$wordArry[$i].' </b>';
			//echo $wordArry[$i] .' ';
		}
		
		// shorten the length of the sentence to 16 words
		
		$haystackArray[$key]['text'] = implode(" ",$wordArry);
		preg_match_all('((?:\S+\s*){0,7}'.$wordArry[$startWIndex].'(?:\s*\S+){0,7})',$haystackArray[$key]['text'],$matches);
		//((?:\S+\s*){0,5}name(?:\s*\S+){0,5})
		//preg_match_all('/(?:\S+\s*){0,7}\S*'.$wordArry[$startWIndex].'\S*(?:\s*\S+){0,7}/s',$haystackArray[$key]['text'],$matches);
		//var_dump($wordArry[$startWIndex]);
		//var_dump($matches[0][0]);
		$haystackArray[$key]['text'] = $matches[0][0];
		//echo $hay['text'] . ' ';
	}
	echo '</pre>';
    return $haystackArray;
}
?>