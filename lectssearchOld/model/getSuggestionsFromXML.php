<?php 
//Created on 09-Mar-2015 by JH-->

function getSuggestionsFromXML($xml, $database, $document) {
	$rawSuggestionList = array();	
	$counter = 0;
	
	if (($document == null) && ($database == "all")) {
		foreach ($xml as $suggestion){
			$rawSuggestionList[$counter]['name'] = (string)$suggestion['name'];
			$rawSuggestionList[$counter]['count'] = (int)$suggestion['total'];
			$counter++;
		}

	}
	elseif (($document != null)&& ($database != "all")) {
		foreach ($xml->suggestion as $suggestion){
			foreach($suggestion->collection as $collection) {
				foreach($collection->occurrence as $occurrence) {
					if($occurrence->attributes()->document == $document) {
						$rawSuggestionList[$counter]['name'] = (string)$suggestion['name'];
						$rawSuggestionList[$counter]['count'] = (int)$occurrence['count'];
						$counter++;
					}		
				}	
			}
		}
	}
	elseif (($document == null)&& ($database != "all")) {
		//echo $database;
		foreach ($xml->suggestion as $suggestion){
			//print_r($suggestion);
			foreach($suggestion->collection as $collection) {
				//print_r($collection->attributes()->db);
				if($collection->attributes()->db == $database) {
					$rawSuggestionList[$counter]['name'] = (string)$suggestion['name'];
					$rawSuggestionList[$counter]['count'] = (int)$collection['subtotal'];
					$counter++;			
				}
			}
		}
	}
	else {
		$rawSuggestionList = null;
	}
	return $rawSuggestionList;
}

