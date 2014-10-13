<?php
//set_time_limit(0);
	// Function: pass a keyword to java file and retrieve the string array
	//		   : Look into 'indexDir' index directory and return the list of ids result
	//	1. Enter Keyword
	//$keyword = 'lakota';
	
	function searchLucene($keyword){
	
	//	2. Set Jar file path
	$pathJar = './luceneJar/searchLucene.jar';
	
	//	3. Execute Jar file with input keyword
	exec ('java -jar ' . $pathJar . ' ' . $keyword, $luceneOut);

	// 	 4. Print result
	//echo "Length of array: " . sizeof($output) . "</br>";
	//echo "Output: " . "</br></br>";
	
	//foreach ($output as $value)
	//	echo $value . "</br>";
	
	return $luceneOut;
}
