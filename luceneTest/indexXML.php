<?php
set_time_limit(0);
	//	Function: load and index all the XML files from 'xmlDir' folder into 'indexDir' respectively
	
	//	IMPORTANT !!: Please remember to clear indexDir before indexing
	//	Current version will create a duplicate index entries if indexDir is not cleared	
	
	//	1. Set Jar file path
	
	$pathJar = 'luceneJar/loadXMLToLucene.jar';
	
	//	2. Execute Jar file with input keyword
	exec ('java -jar ' . $pathJar, $output);

	// 	 3. Print result
	foreach ($output as $value)
		echo $value . "</br>";
		
		
	//	'indexDir' folder should be now populated with Lucene index files after the execution is successful	
	?>