<?php


//	Description: Extract information from lucene search result
//	input = Lucene search result stored in array
//	output = 2-D array of search result array[index]['*usefulinfo']
//	*usefulinfo= document name, segementID, sentenceID, start time/wordID, text
//	need to reorganize by database in case of search in multiple databases
/*$searchDocInfo[$counter-1]['docname'] = $fileinfo[0];
$searchDocInfo[$counter-1]['segmentID'] = $fileinfo[1];
$searchDocInfo[$counter-1]['speakerID'] = $fileinfo[2];
$searchDocInfo[$counter-1]['sentenceID'] = $fileinfo[3];
$searchDocInfo[$counter-1]['startTime'] = $fileinfo[4];
$searchDocInfo[$counter-1]['text'] = $fileinfo[5];
$searchDocInfo[$counter-1]['word'] = "";

function getInfoFromSearch($luceneOut){
  //var_dump($luceneOut);
  $fileinfo = array();
  $searchDocInfo = array();
  $counter = 0;
  foreach($luceneOut as $file){
    //echo "\n $file  toto\n";
    $fileinfo = explode(",", $file);

    $docName 	= $fileinfo[0];
    $segId 		= $fileinfo[1];
    $sentenceId     = $fileinfo[3];

    $searchDocInfo[$docName][ (int) $segId ][(int) $sentenceId]['speakerId'] = $fileinfo[2];
    $searchDocInfo[$docName][ (int) $segId ][(int) $sentenceId]['startTime'] = $fileinfo[4];
    $searchDocInfo[$docName][ (int) $segId ][(int) $sentenceId]['text'] = $fileinfo[5];
    asort($searchDocInfo[$docName]);
  }
  return $searchDocInfo;
}*/

function rearrangeInfoFromSearch($preresultArray) {

  $resultArray = array();
  foreach($preresultArray as $key) {
    //print_r($key);
    $docName = $key['docname'];
    $segId 		= $key['segmentID'];
    $sentenceId = $key['sentenceID'];

    $resultArray[$docName][ (int) $segId ][(int) $sentenceId]['speakerId'] = $key['speakerID'];
    $resultArray[$docName][ (int) $segId ][(int) $sentenceId]['startTime'] = $key['startTime'];
    $resultArray[$docName][ (int) $segId ][(int) $sentenceId]['text'] = $key['text'];
    asort($resultArray[$docName]);

  }
  //print_r($resultArray);
  return $resultArray;

}
