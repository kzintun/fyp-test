<?php
//$keyword=$_POST['searchfield'];
//~ $collection = html_entity_decode($_GET['database']);
//~ $docName = html_entity_decode($_GET['document']);
$keyword   = html_entity_decode($_GET['keyword']);
//~ $searchResultArray = html_entity_decode($_SESSION['keywordSearchResult']);
$dir='./collections';
$extension='.xml';
// if undefined $keyword => do nothing or prompt a message

if ( isset($keyword) AND !(empty($keyword) )){	
	
	include_once('./model/searchLucene.php');		
	include_once('./model/getInfoFromSearch.php');
	include_once('model/getFileList.php');
	include_once('./model/highlightKeyword.php');
	
	//	initialize arrays
	$resultArray = array();
	// format is array[keyword][db][doc][0,1,2]	
	//~ $sortedResultArray = array();
	$finalResultArray = array();
	$finalDisplayArray = array();
	
	//1. get list of Databases
	if (is_dir($dir)){
		$databaseList=getFileList($dir, $extension);
	}
		
	// 2. for each database, look into lucene	
	foreach ($databaseList as $db){
		//~  let's simplify the process the extraction of the name of the collection
		$db = pathinfo($db, PATHINFO_FILENAME);		
		if ( !(isset($searchResultArray[$keyword][$db] ))){			
					
			// get the raw search (the two following functions could be join)
			$luceneOut = searchLucene($keyword, $db);
						
			// process the raw search and return an hash table			
			// hash[doc][seg][sent][blah]
			$resultArray = getInfoFromSearch($luceneOut);

			//~ highlight the keyword in the text
			$resultArray=highlightKeyword($resultArray, $keyword, true);

			//~ then append the new array to the collection	
			// ~ if not empty table we append it to the big search result variable
			
			if (count($resultArray) != 0){
				if ( empty($searchResultArray[$keyword])){
					// initialize the array only if required
					$searchResultArray[$keyword] = array();					
				}					
				$searchResultArray[$keyword][$db] = array();		
				$searchResultArray[$keyword][$db] = array_merge($searchResultArray[$keyword][$db], $resultArray);
			}			
		}		
	}	

	if ( empty($searchResultArray) ){
		$errorMessage='No search results are found. ';
		include_once('./view/errorFile.php');
	}	
	else{
		// arrange the list by count and files
		include_once('model/sortByCount.php');
		$sortedResultArray = sortByCount($searchResultArray[$keyword], $keyword);
		$_SESSION['resultArray'] = $sortedResultArray;

		//~ print_r($sortedResultArray);
		
		include_once('view/displaySearch.php');	
		//~ include_once('view/displayContentAndSearch.php');
	}
}
else{
	$errorMessage="Enter a keyword in the search box";
	include_once('./view/errorFile.php');
}

?>
