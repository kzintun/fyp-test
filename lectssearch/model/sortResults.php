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

function aggregate($srList,$collection){
  $aggregated = array();
  $counter = 0;
  foreach($srList as $result){
	if(!array_key_exists($result['docname'], $aggregated)){
	  $counter = 0;
	}
	  //$aggregated[$result['docname']][$counter]= $result;
	  $aggregated[$result['docname']][$counter]['segmentID']= $result['segmentID'];
	  $aggregated[$result['docname']][$counter]['speakerID']= $result['speakerID'];
	  $aggregated[$result['docname']][$counter]['sentenceID']= $result['speakerID'];
	  $aggregated[$result['docname']][$counter]['startTime']= $result['startTime'];
	  $aggregated[$result['docname']][$counter]['text']= $result['text'];
	  $aggregated[$result['docname']][$counter]['collection']= $collection;
	  $counter++;
  }
  return $aggregated;
}


			