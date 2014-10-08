<?php
	// Function: pass a keyword to java file and retrieve the string array
	
	//	1. Enter Keyword
	$keyword = 'what is lakota';
	
	//	2. Set Java / Jar file path
	
	//  2a. Java file path
	//	This is the classpath of java class file + external libraries and actual java file to execute 
	//	                             (bin folder + lucene libraries)  and (xmlIndexLucene.searchGUI) (Folder Name . java file name)  
	//$pathJava = 'F:\eclipse\workplace\xmlIndexLucene\bin;C:\Users\KZT\Downloads\lucene-4.10.0\lucene-4.10.0\core\lucene-core-4.10.0.jar;C:\Users\KZT\Downloads\lucene-4.10.0\lucene-4.10.0\analysis\common\lucene-analyzers-common-4.10.0.jar;C:\Users\KZT\Downloads\lucene-4.10.0\lucene-4.10.0\queryparser\lucene-queryparser-4.10.0.jar xmlIndexLucene.searchGUI';
	//exec ('java -cp '.$pathJava .' '. $keyword, $output);
	
	//	2b. Jar file path
	$pathJar = 'luceneJar/searchLucene.jar';
	exec ('java -jar ' . $pathJar . ' ' . $keyword, $output);
	
	
	// direct execution
	//exec('java -cp F:\eclipse\workplace\xmlIndexLucene\bin;C:\Users\KZT\Downloads\lucene-4.10.0\lucene-4.10.0\core\lucene-core-4.10.0.jar;C:\Users\KZT\Downloads\lucene-4.10.0\lucene-4.10.0\analysis\common\lucene-analyzers-common-4.10.0.jar;C:\Users\KZT\Downloads\lucene-4.10.0\lucene-4.10.0\queryparser\lucene-queryparser-4.10.0.jar xmlIndexLucene.searchGUI', $output);
	//$last_line = system('java -cp F:\eclipse\workplace\xmlIndexLucene\bin;C:\Users\KZT\Downloads\lucene-4.10.0\lucene-4.10.0\core\lucene-core-4.10.0.jar;C:\Users\KZT\Downloads\lucene-4.10.0\lucene-4.10.0\analysis\common\lucene-analyzers-common-4.10.0.jar;C:\Users\KZT\Downloads\lucene-4.10.0\lucene-4.10.0\queryparser\lucene-queryparser-4.10.0.jar xmlIndexLucene.searchGUI', $retval);
	//echo $last_line;

	
	// 	 3. Print result
	echo "Length of array: " . sizeof($output) . "</br>";
	echo "Output: " . "</br>";
	
	foreach ($output as $value)
		echo $value . "</br>";
	?>