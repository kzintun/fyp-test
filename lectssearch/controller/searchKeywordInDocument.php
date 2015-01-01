<?php
//$keyword=$_POST['searchfield'];
$collection = html_entity_decode($_GET['database']);
$document = html_entity_decode($_GET['document']);
if (isset($_GET['keyword'])		){
	$keyword   = html_entity_decode($_GET['keyword']);
}
//~ $searchResultArray = html_entity_decode($_SESSION['keywordSearchResult']);
//~ $dir='./collections';
//~ $extension='.xml';
// if undefined $keyword => do nothing or prompt a message

if ( isset($keyword) AND !(empty($keyword) )){

	include_once('./model/searchLucene.php');
	include_once('./model/getInfoFromSearch.php');
	include_once('model/getFileList.php');
	//~ include_once('./model/highlightKeyword.php');

	//	initialize arrays
	$resultArray = array();
	// format is array[keyword][db][doc][0,1,2]
	//~ $sortedResultArray = array();
	$finalResultArray = array();
	$finalDisplayArray = array();

	//1. get list of Databases
	//~ if (is_dir($dir)){
	//~ $databaseList=getFileList($dir, $extension);
	$databaseList[]=$collection;
	//~ }


	// 2. for each database, look into lucene
	foreach ($databaseList as $db){
		//~  let's simplify the process the extraction of the name of the collection
		$db = pathinfo($db, PATHINFO_FILENAME);
		if ( !(isset($searchResultArray[$keyword][$db] ))){

			// get the raw search (the two following functions could be join)
			$luceneOut = searchLucene($keyword, $db);

			if ($luceneOut != -1){
				// process the raw search and return an hash table
				// hash[doc][seg][sent][blah]
				$preresultArray = getInfoFromSearch($luceneOut);
				// NEW by JH
				include_once('./model/rearrangeInfoFromSearch.php');
				$resultArray = rearrangeInfoFromSearch($preresultArray);
				//print_r($resultArray);

				//~ highlight the keyword in the text
				//~ $resultArray=highlightKeyword($resultArray, $keyword, true);

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
	}
	// print_r($searchResultArray);

	//if ( empty($searchResultArray)){
	//	$errorMessage='No result for ' . $keyword;
	//	include_once('./view/errorFile.php');
	//}
	//else{
	// arrange the list by count and files
	if ( empty($searchResultArray)){
		$sortedResultArray = array();
	}
	else{
		include_once('model/sortByDocumentAndCount.php');
		//~ print_r($searchResultArray);
		$sortedResultArray = sortByDocumentAndCount($searchResultArray[$keyword], $document, $keyword);
		// print_r($sortedResultArray);
	}


	include_once("model/loadXML.php");
	//~ $xml=loadXMLFile($xmlLoc);
	$xmlLoc = './documents/'.$document.'.xml';
	$xml=loadXML($xmlLoc);

	include_once("model/getMetadataFromXmlDocument.php");
	$docInfo = getMetadataFromXmlDocument($xml);

	include_once("model/loadTranscript.php");
	$transcript = loadTranscript($xml);

	include_once("model/prepareSegTranscript.php");
	$printScript = prepSegTranscript($transcript, $docInfo , $document);


	if ( empty($sortedResultArray)){
		$matchList = array();
	}
	else{
		include_once("model/getMatchList.php");
		//print_r($printScript);
		$matchList = getMatchList($printScript[0]['eq'], $sortedResultArray);
		//$matchList = getMatchList($printScript['eq'], $sortedResultArray);
	}
	//print_r($matchList);
	//~ $_SESSION['resultArray'] = $sortedResultArray;

	//~ print_r($sortedResultArray);
	include_once("view/displayContent.php");

	//~ $_SESSION['resultArray'] = $sortedResultArray;
	//~ print_r($sortedResultArray);

	//~ include_once('view/displayDocWithSearch.php');
	//~ include_once('view/displayContentAndSearch.php');
	//}
}
else{
	$errorMessage="Enter a keyword in the search box";
	include_once('./view/errorFile.php');
}

?>
