<?php
	
if (isset($keyword)){
	
	$resultArray = array();
	include_once('model/searchLucene.php');
	$luceneOut = searchLucene($keyword);
	
	if ( sizeof($luceneOut) == 1 ){
		
		// Note:
		// first line of output from lucene shows how many rows of result were found.
		// Hence, before extracting info from array, first line has to be skipped.
		// Alt: I can also remove that line from lucene output
		
		//~ array list is empty
		$errorMessage="No search results are found";
		include_once('view/errorFile.php');
	}
	else{
		
		include_once('model/getInfoFromSearch.php');
		$resultArray = getInfoFromSearch($luceneOut);
		
		// Printing the results
		//for ($k=1 ; $k <= sizeof($resultArray); $k++){
		//	echo $resultArray[$k]['name'] . '</br>';
		//	echo $resultArray[$k]['segmentID'] . '</br>';
		//	echo $resultArray[$k]['speakerID'] . '</br>';
		//	echo $resultArray[$k]['sentenceID'] . '</br>';
		//	echo $resultArray[$k]['startTime'] . '</br>';
		//	}
		
		// ** To be implemented next **
		//include_once('view/display???.php');
	}	
}
else{
	$errorMessage="Enter a keyword in the search box";
	include_once('view/errorFile.php');
}
	

?>