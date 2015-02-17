<?php


function compareConcepts($curConArray,$newConArray){

	
	$matchedArray = array();
	$counter = 0;

	foreach($curConArray as $arr1){
				//echo '<pre>';
				//print_r($arr1);
				//echo '</pre>';
		//echo 'array1 :'. $arr1['docname'] . '<br>';
		
		foreach($newConArray as $arr2){
			//echo 'array2 :'. $arr2['docname'] . '<br>';
			
			if($arr2['docname']==$arr1['docname'] && $arr2['segmentID']==$arr1['segmentID'] && $arr2['sentenceID']==$arr1['sentenceID']){
            //echo $arr1['docname'] .'<br>';
			$matchedArray[$counter] = $arr1;
			$counter++;
			}
		}
	}			
				
				//echo '<pre>';
				//echo 'Size of first array: ' . sizeof($curConArray) .'. Size of second array: '.sizeof($newConArray) . '. Size of AND array: ' . sizeof($matchedArray) .'<br>';
				//print_r($newConArray);
				//print_r($matchedArray);
				//echo '</pre>';
	return $matchedArray;
}
