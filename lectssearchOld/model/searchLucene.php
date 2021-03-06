<?php
//set_time_limit(0);
	// Description: pass a keyword to java file and retrieve the string array
	//		   	  : Look into 'indexDir' index directory and return the list of ids result
	//	input = String keyword/search query, String name of collection/database
	//	output = multiple lines of output from lucene stored in an array	
	//~ java -jar queryDB.jar "engine" MIT_Aerospace
	
	function searchLucene($keyword, $collection){
	
	//	1. Set Jar file path
	$pathJar = './luceneJar/searchLucene.jar';
	
	//	2. Execute Jar file with input keyword
	exec ('java -jar ' . $pathJar . ' ' . $keyword . ' ' . $collection, $luceneOut);
	
	if ( $luceneOut[0] == "the database does not exits" ){		
		return -1;
	}
	
	return $luceneOut;
}
