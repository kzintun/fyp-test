<?php
/*
 * The MIT License (MIT)
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author Bejamin Bigot (c) 2013
 * @author Ong Jia Hui (c) 2015
 * @author Kyaw Zin Tun (c) 2015
 */
if (isset($keyword)){
	
	//	initialize
	$resultArray = array();
	$sortedResultArray = array();
	
	// GET database/collection name here (currently hard-coded)
	$collection = 'aerospace';
	
	//	1. Search from Lucene
	include_once('./model/searchLucene.php');
	$luceneOut = searchLucene($keyword,$collection);
	
	if ( sizeof($luceneOut) == 1 ){
		
		 /* Note:
		 First line of output from lucene shows how many rows of result were found or error message. e.g. Found N hits, Index not found, etc
		 Here we can handle different error messages generated from Lucene and pass values to error page
		 Hence, before extracting info from array, first line has to be skipped. */
		
		
		// get error message
		$value = $luceneOut[0];
		$errorMessage='No search results are found.</br>Error Details: '. $value;
		
		include_once('./view/errorFile.php');
	}
	else{
		// **Begin extraction of information from lucene search**
		
		/* 	2.	Extract useful info from results
		 Extract 'attribute': docname, segmentID, speakerID, sentenceID and startTime
		 from the lucene output
		 stored in 2D array $resultArray[]['attribute'] */
		include_once('./model/getInfoFromSearch.php');
		$resultArray = getInfoFromSearch($luceneOut);
		
		
		/* 	3. Sorting
			a.	Sort the results array(s)
		 Array A*/
		 array_multisort($resultArray);
		
		/*  b. Compare all the documents that contained searched keyword
		 To be used to determine which document contains more search keywords than the rest of searched documents
		 Array B */
		$vals = array_count_values(array_column($resultArray,'docname'));
		array_multisort($vals, SORT_DESC);
		
	
		/* 	4.	Remove stopwords from the keyword
		 Remove Lucene stopwords from user query	 */
		include_once('./model/removeStopWords.php');
		$keyword = removeStopWords($keyword);
			
		/* 	5.	Highlight the all the keywords contained in the search result
		 Highlight keyword from the search results text */
		//$wordList = explode(" ", $keyword);
		include_once('./model/highlightKeyword.php');
		//$resultArray=highlightKeyword($resultArray,$wordList);
		$resultArray=highlightKeyword($resultArray,$keyword);
		//	6.	create a 3D array by sorting the 2D resultArray 
		//	Array C
		include_once('./model/sortResults.php');
		$sortedResultArray= aggregate($resultArray);
		
		// -----------------------testing block------------------------------
		//	You can clear comment  below codes to view the array format 
		/* echo 'Array B:</br>';
		print_r($vals);			//<---- Output 1: Array $vals
		echo '</br></br>';
		
		echo 'Array C:</br>';
		print_r($sortedResultArray);   // <---- Output 2: Array $sortedResultArray
		echo '</br></br>';  */
		
		// Printing the contents of sorted result array (Array C)
		/*   foreach ($sortedResultArray as $key => $value){
			echo '</br><u>'.$key . '</u></br>';
			for ($k=0 ; $k < sizeof($value); $k++){
				echo '</br>';
				echo $value[$k]['segmentID'] . '</br>';
				echo $value[$k]['speakerID'] . '</br>';
				echo $value[$k]['sentenceID'] . '</br>';
				echo $value[$k]['startTime'] . '</br></br>';
				echo $value[$k]['text'] . '</br>';
				} 
		}  */
		// ----------------- block end ----------------------------------------
		
		 /* 7.	Pass to VIEW page
		 ** To be implemented next ** */
		//include_once('view/display???.php');
	}	
}
else{
	$errorMessage="Enter a keyword in the search box";
	include_once('./view/errorFile.php');
}
	

?>