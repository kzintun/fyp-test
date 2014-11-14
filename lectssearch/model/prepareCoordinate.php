<?php

//	Description: Create a multidimensional array of search results
// 		 Format: Array{ [$documentname] =>	Array(
//											[index: 0 - N] => Array (
//																	['segmentID'] => valueA
//				 								     				['speakerID'] => valueB	
//												     				['sentenceID'] => valueC
//                                    				 				['wordID/startTime'] => valueD
//                                     				 				['text'] => valueE	))}
//	input = sorted 2D array that stored search results
//	output = a multidimensional array following the above mentioned format.

function prepareCoordinate($srList){
  $aggregated = array();
  $counter = 0;
  $wordID =0;
  $arr_remove = array('<b>','</b>');
  
  foreach ($srList as $key => $value){
  
	//echo $key. ' :no. of sentences: '. sizeof($value).'</br>';
	for ($k=0 ; $k < sizeof($value); $k++){
		
		// for each sentence
		$wordsInSentence = explode(" ", $value[$k]['text']);
		//echo 'no. of words in a sentence: '.sizeof($wordsInSentence).'</br>';
		for ($i = 0 ; $i < sizeof($wordsInSentence); $i++)
		{
			if (str_replace($arr_remove,'',$wordsInSentence[$i]) == str_replace(' ','',$value[$k]['word'])){
			//if ($word2 == str_replace(' ','',$value[$k]['word'])){
				break;
			}	
			$wordID++;	 	
		} 
		if ( !isset($aggregated[$key]) || !array_key_exists($value[$k]['word'],$aggregated[$key]))
		{
			$counter=0;
		}
		$aggregated[$key][$value[$k]['word']][$counter]= $value[$k]['segmentID']. ','. $value[$k]['sentenceID'] . ',' . $wordID;
		$counter++;
		$wordID=0;
	 }
	 // $counter=0;
  }
  return $aggregated;
}
