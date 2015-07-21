<?php

$collection = html_entity_decode($_GET['database']);
$docName = html_entity_decode($_GET['document']);
$keyword   = html_entity_decode($_GET['keyword']);
$searchResult = $_SESSION['resultArray'] ;
$videoPath = './documents';
// check variables.

if ( isset($searchResult) AND !(empty($searchResult)){
	
	// search results are ok
	
	
	
	
}
