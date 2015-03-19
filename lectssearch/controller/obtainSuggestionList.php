<?php

if(isset($_GET['document'])) $document=html_entity_decode($_GET['document']);
else $document = null;
if(isset($_GET['database'])) $database=html_entity_decode($_GET['database']);
else $database = "all";

$xmlLoc = './suggestionDir/suggestions.xml';

if (file_exists($xmlLoc)) {
	include_once("model/loadXML.php");
	$xml=loadXML($xmlLoc);

	include_once("model/getSuggestionsFromXML.php");
	$rawSuggestionList = getSuggestionsFromXML($xml, $database, $document);

	if ($rawSuggestionList != null) {
		include_once("model/rankSuggestions.php");
		$rankedSuggestionList = rankSuggestions($rawSuggestionList);
		//include_once("model/extractFinalSuggestionList.php");
		//$rankedSuggestionList = extractFinalSuggestionList($rankedSuggestionList);
	}
	else {
		$rankedSuggestionList = array();
	}
	//print_r($rankedSuggestionList);

}
else {
	return false;
}
