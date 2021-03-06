<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();

//~ for i in $(find documents -name *.xml); dojava -jar indexDoc.jar $i MIT_Aerospace ;echo $i  ; done
include_once('controller/obtainSuggestionList.php');
if ( !isset($_GET) OR empty($_GET) ){
	//	Scenario 1 : home page, list the collections present in the database directory

	include_once('controller/listDatabase.php');
}
elseif ( isset($_POST['document'])  AND  isset($_POST['database']) AND isset($_POST['matches'])){
	//	Scenario X - one collection selected, one document selected, matches selected
	//  AJAX Function;
	include_once('controller/obtainMatchList.php');
}

elseif ( isset($_GET['database']) AND  (!isset($_GET['document']) OR empty($_GET['document'])) AND !isset($_GET['keyword']) AND !isset($_GET['concept']) ){
	//	Scenario 2 - one collection selected, no document selected, no keyword
	// => show the list of doc in the collection
	//~ include_once('controller/loadAndShowCollectionFiles.php');
	include_once('controller/showOneCollection.php');
}

elseif ( isset($_GET['document'])  AND  isset($_GET['database']) AND ( !isset($_GET['keyword'])  OR  empty($_GET['keyword']) ) AND !isset($_GET['concept'])){
	//	Scenario 3 - collection selected, a document is selected, no keyword searched => show the transcription of the document. starting time is zero
	// show doc without search
	//~ include_once('controller/loadAndShowDocument.php');

	include_once('controller/showOneDocument.php');
}

elseif ( !isset($_GET['document'])  AND  !isset($_GET['database']) AND isset($_GET['keyword'])  AND ( !isset($_GET['seek'])  OR  empty($_GET['seek']) )){
	//	Scenario 4 - no collection selected, no document selected, one keyword selected
	// => search in all databases
	//echo "search in all db";
	include_once('controller/searchKeyword.php');
}

elseif ( !isset($_GET['document'])  AND  isset($_GET['database']) AND isset($_GET['keyword'])  AND ( !isset($_GET['seek'])  OR  empty($_GET['seek'])  )){
	//	Scenario 5 - one collection selected, one keyword selected
	include_once('controller/searchKeyword.php');
}

elseif ( !isset($_GET['document'])  AND  isset($_GET['database']) AND isset($_GET['concept'])  AND ( !isset($_GET['seek'])  OR  empty($_GET['seek'])  )){
	//	Scenario 5 - one collection selected, one concept selected
	include_once('controller/searchConcept.php');
}

elseif ( isset($_GET['document'])  AND  isset($_GET['database']) AND isset($_GET['keyword'])){
	//	Scenario 6 - one collection selected, one document selected, one keyword selected
	//echo "GOING IN KEYWORD SEARCH";
	include_once('controller/searchKeywordInDocument.php');
}

elseif ( isset($_GET['document'])  AND  isset($_GET['database']) AND isset($_GET['concept'])){
	//	Scenario 6 - one collection selected, one document selected, one keyword selected
	//echo "GOING IN CONCEPT SEARCH";
	include_once('controller/searchConceptInDocument.php');
}

//elseif ( isset($_GET['document'])  AND  isset($_GET['database']) AND isset($_GET['keyword']) AND isset($_GET['seek']) ){
	// seek defined means that a search has been done
	//	Scenario 6 - one collection selected, one document selected, one keyword selected
	//~ include_once('controller/searchKeywordInDocument.php');
	//include_once('controller/naviguateInDocumentSearch');
//}

?>
