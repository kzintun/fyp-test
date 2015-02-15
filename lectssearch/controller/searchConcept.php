<?php

//$concept=$_POST['searchfield'];
if (!isset( $_GET['database']))
	$collList = "all";
else
	$collList = $_GET['database'];
	$concept = $_GET['concept'];

if (isset($concept)){
	
	//	initialize
	$resultArray = array();
	$sortedResultArray = array();
	$finalResultArray = array();
	$finalDisplayArray = array();
	
	
	foreach ((array)$collList as $collection)
	{
		$conceptXMLFile = $collection.".xml";
	
	
		include_once('./model/searchConceptXML.php');
		$xmlOut = searchConceptXML($concept, $conceptXMLFile);

	
		include_once('./model/getInfoFromConceptSearch.php');
		$resultArray = getInfoFromConceptSearch($xmlOut);
				
		array_multisort($resultArray);
				
				
		$vals = array_count_values(array_column($resultArray,'docname'));
		array_multisort($vals, SORT_DESC);
				
			
		//include_once('./model/removeStopWords.php');
		//$concept = removeStopWords($concept);
					
			
		//include_once('./model/highlightconcept.php');
		//$resultArray=highlightconcept($resultArray,$concept);
		
		include_once('./model/sortResults.php');
		$sortedResultArray= aggregate($resultArray,$collection);
		 
		$finalResultArray = array_merge($finalResultArray,$sortedResultArray);
		$finalDisplayArray = array_merge($finalDisplayArray,$vals);
		array_multisort($finalDisplayArray, SORT_DESC);

		include_once('./model/extractMatchListFromArray.php');
		$matchSegmentArray = extractMatchListFromArray($finalResultArray);
				
				
		}// end of foreach $collList loop	
		
		if ( sizeof($finalResultArray) == 0 )
		{
				//echo sizeof($finalResultArray);
				//print_r($finalResultArray);
				$errorMessage='No search results are found. ';
				include_once('./view/errorFile.php');
		}
		
		else{
		include_once('view/displaySearch.php');	
	
		}
}
else{
	$errorMessage="Enter a concept in the search box";
	include_once('./view/errorFile.php');
}
	

?>