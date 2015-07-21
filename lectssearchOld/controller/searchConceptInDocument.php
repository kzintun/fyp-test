<?php
//$concept=$_POST['searchfield'];
//echo "HERE";
$database = html_entity_decode($_GET['database']);
$document = html_entity_decode($_GET['document']);
if (isset($_GET['concept'])		){
	$concept   = html_entity_decode($_GET['concept']);
	//echo $concept;
}
//~ $searchResultArray = html_entity_decode($_SESSION['conceptSearchResult']);
//~ $dir='./collections';
//~ $extension='.xml';
// if undefined $concept => do nothing or prompt a message

if ( isset($concept) AND !(empty($concept) )){
	
	include_once('model/getFileList.php');
	//~ include_once('./model/highlightconcept.php');

	//	initialize arrays
	$resultArray = array();
	$finalResultArray = array();
	$finalDisplayArray = array();

	//1. get list of Databases
	//~ if (is_dir($dir)){
	//~ $databaseList=getFileList($dir, $extension);
	$databaseList[]=$database;
	//~ }


	// 2. for each database, look into lucene
	foreach ($databaseList as $db){
		//~  let's simplify the process the extraction of the name of the database
		$db = pathinfo($db, PATHINFO_FILENAME);
		if ( !(isset($searchResultArray[$concept][$db] ))){
			$conceptXMLFile = $db.".xml";
			// get the raw search (the two following functions could be join)
			include_once('./model/searchConceptXML.php');
			$xmlOut = searchConceptXML($concept, $conceptXMLFile);
			//$luceneOut = searchLucene($concept, $db);

			if ($xmlOut != -1){
				// process the raw search and return an hash table
				// hash[doc][seg][sent][blah]
				include_once('./model/getInfoFromConceptSearch.php');
				$preresultArray = getInfoFromConceptSearch($xmlOut);
				
				// NEW by JH
				include_once('./model/rearrangeInfoFromSearch.php');
				$resultArray = rearrangeInfoFromSearch($preresultArray);
				//print_r($resultArray);

				//~ highlight the concept in the text
				//~ $resultArray=highlightconcept($resultArray, $concept, true);

				//~ then append the new array to the database
				// ~ if not empty table we append it to the big search result variable



				if (count($resultArray) != 0){
					if ( empty($searchResultArray[$concept])){
						// initialize the array only if required
						$searchResultArray[$concept] = array();
					}
					$searchResultArray[$concept][$db] = array();
					$searchResultArray[$concept][$db] = array_merge($searchResultArray[$concept][$db], $resultArray);
				}
			}
		}
	}
	// print_r($searchResultArray);

	//if ( empty($searchResultArray)){
	//	$errorMessage='No result for ' . $concept;
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
		$sortedResultArray = sortByDocumentAndCount($searchResultArray[$concept], $document, $concept);

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
		
		//print_r($printScript);
		//$matchList = getMatchList($printScript[0]['eq'], $sortedResultArray);
		include_once('./model/createEquivalence.php');
		$equivalence = createEquivalence($printScript);
		include_once("model/getMatchList.php");
		$matchList = getMatchList($equivalence, $sortedResultArray);
		//$matchList = getMatchList($printScript['eq'], $sortedResultArray);
	}
	//print_r($matchList);
	//~ $_SESSION['resultArray'] = $sortedResultArray;

	//~ print_r($sortedResultArray);
	//include_once("view/displayContent.php");
	/*		print_r("<pre>");
		//	print_r($searchResultArray);
		//print_r($sortedResultArray);
		print_r($equivalence);

		print_r($printScript);
		print_r("</pre>");	*/
	echo json_encode($matchList);
	//~ $_SESSION['resultArray'] = $sortedResultArray;
	//~ print_r($sortedResultArray);

	//~ include_once('view/displayDocWithSearch.php');
	//~ include_once('view/displayContentAndSearch.php');
	//}
}
else{
	$errorMessage="Enter a concept in the search box";
	include_once('./view/errorFile.php');
}

?>
