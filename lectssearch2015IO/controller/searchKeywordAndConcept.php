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
 * @author Kyaw Zin Tun (c) 2015
 */
//$keyword=$_POST['searchfield'];
//if (!isset( $_GET['database']))
//	$database = "all";
//else

//echo 'Scenario Y';

$database = $_GET['database'];
$keyword = $_GET['keyword'];
$concept = $_GET['concept'];
$resultArrayKC = array();
$sortedResultArrayKC = array();
$finalResultArray = array();
$finalDisplayArray = array();


// ------------------------- Keyword search first ----------------------------------- //
if (isset($keyword)){
	
	//	initialize
	$resultArrayK = array();
	$sortedResultArrayK= array();
	$finalResultArrayK = array();
	$finalDisplayArrayK = array();
	
	// GET database/collection name here (currently hard-coded)
	//$collection = 'aerospace';
	
	
	
	if ($database == 'all')
	{
		//echo $database;
		$colDir = './collections' ;
		$ext = '.xml';
		include_once('model/getFileList.php');
		$database = getFileList($colDir,$ext);	
	}
	else {
		include_once("model/calConceptToDoc.php");
		$treeTable=calculateConcepts($database);
	}
	//print_r($colList);
	foreach ((array)$database as $collection)
	{
			//echo $database;
			$collection = preg_replace('/\\.[^.\\s]{3,4}$/', '', $collection);
			//	1. Search from Lucene
			include_once('./model/searchLucene.php');
			$luceneOut = searchLucene($keyword,$collection);
			//print_r($luceneOut);
	
			/* if ( sizeof($luceneOut) == 1 ){
				
				 
				$value = $luceneOut[0];
				$errorMessage='No search results are found in ' .$collection.'</br>Error Details: '. $value;
				
				include_once('./view/errorFile.php');
			}
			else{ */
			
				include_once('./model/getInfoFromSearch.php');
				$resultArrayK = getInfoFromSearch($luceneOut);
				
			//	echo '<pre>';
				//print_r($luceneOut);
				//echo '</br>';
				//print_r($resultArrayK);
				//echo '</pre>'; 
				
				array_multisort($resultArrayK);
				
				//print_r($resultArrayK);
				//echo '</pre>';
				
				$valsK = array_count_values(array_column($resultArrayK,'docname'));
				array_multisort($valsK, SORT_DESC);
				
			
				include_once('./model/removeStopWords.php');
				$newkeyword = removeStopWords($keyword);
					
			
				include_once('./model/highlightKeyword.php');
		
				$resultArrayK=highlightKeyword($resultArrayK,$newkeyword);
				
				//echo '<pre>';
				//print_r($resultArrayK);
				//echo '</pre>';
				
				include_once('./model/sortResults.php');
				$sortedResultArrayK= aggregate($resultArrayK,$collection);

				
				 
				 
				$finalResultArrayK = array_merge($finalResultArrayK,$sortedResultArrayK);
				$finalDisplayArrayK = array_merge($finalDisplayArrayK,$valsK);
				array_multisort($finalDisplayArrayK, SORT_DESC);

				include_once('./model/extractMatchListFromArray.php');
				$matchSegmentArray = extractMatchListFromArray($finalResultArrayK);
				
	}	// end of foreach $database loop	
		
		if ( sizeof($finalResultArrayK) == 0 )
		{
				//echo sizeof($finalResultArray);
				//print_r($finalResultArray);
				if (isset($luceneOut[0]))
				$errorMessage=$luceneOut[0];
				else
				$errorMessage='No search results are found. ';
				
				// Google 'Did you mean'
				//include_once('./model/getGoogleSuggestion.php');
				//$suggestionMsg=getGoogleSuggestions1($keyword);
				
				// Lucene 'Did you mean'
				//print_r( $database);
				for($index=0; $index<sizeof((array)$database); $index++)
					$database[$index]= pathinfo($database[$index], PATHINFO_FILENAME );
					
				$dictcollection = implode(",", (array)$database);
				include_once('./model/checkSpelling.php');
				$suggestionMsg = checkSpelling($keyword, $dictcollection);
				
				include_once('./view/errorFile.php');
		}
		
		else{
		
		// new addition to rank sorting
		include_once('model/newRankSort.php');
		
		// add ranking here
		//$sortedResultArray = sortRank($sortedResultArray, $collection, $docInfo,$vals, $newkeyword);
		//$finalResultArrayK = sortRank($finalResultArrayK, $database);
		//echo '<pre>';
		
		//foreach ($finalResultArrayK as $key => $row) {
		
			//print_r($row);
		//	$rank[$key] = $row['score'];
		//}
		
		//array_multisort($rank, SORT_ASC, $finalResultArrayK);
		
		// end rank sorting
		// echo '<pre>';
		//print_r($gg);
		//echo '</pre>'; 
		//include_once('view/displaySearch.php');	
		/* echo '<pre>';
		print_r($finalDisplayArray);
		echo '</pre>'; */
		}
}

// ------------------------------------------- Concept Search ---------------------------------------------------//
if (isset($concept)){
	
	//	initialize
	$resultArrayC = array();
	$resultArray1C = array();
	$resultArray2C = array();
	$sortedResultArrayC = array();
	$finalResultArrayC = array();
	$finalDisplayArrayC = array();
	$conceptArry = array ();
	
	
	$conceptArry = explode(", ", $concept);
	
	//print_r($conceptArry);
	
	if($database != "all") {
		include_once("model/calConceptToDoc.php");
		$treeTable=calculateConcepts($database);
	}
	foreach ((array)$database as $collection)
	{
	
		$conceptXMLFile = $collection.".xml";
		
		include_once('./model/searchConceptXML.php');
		//$xmlOut = searchConceptXML($concept, $conceptXMLFile);
		$xmlOut = searchConceptXML($conceptArry[0], $conceptXMLFile);
	
		include_once('./model/getInfoFromConceptSearch.php');
		$resultArrayC = getInfoFromConceptSearch($xmlOut);
		
		if (sizeof($conceptArry) > 1)
		{
			//$xmlOut1 = searchConceptXML($conceptArry[0], $conceptXMLFile);
			//$resultArray1 = getInfoFromConceptSearch($xmlOut1);
			
			include_once('./model/compareConceptAND.php');
			//echo 'no of search concepts: ' . sizeof($conceptArry) .'<br>';
			for ($i=1 ; $i< sizeof($conceptArry); $i++)
			{
				//echo $i.'th concept:'.$conceptArry[1] . '<br>';
				$xmlOut2 = searchConceptXML($conceptArry[$i], $conceptXMLFile);
				//$xmlOut2 = searchConceptXML('SS01', $conceptXMLFile);
				//print_r($xmlOut2);
				$resultArray2C = getInfoFromConceptSearch($xmlOut2);
				//echo '<pre>';
				//print_r($resultArray2);
				//echo '</pre>';
				$resultArrayC = compareConcepts($resultArrayC , $resultArray2C);
				
			}
		}

		array_multisort($resultArrayC);
				
				
		$valsC = array_count_values(array_column($resultArrayC ,'docname'));
		array_multisort($valsC, SORT_DESC);
					
					
			
		include_once('./model/highlightConcept.php');
		//$resultArrayC=highlightConcept($resultArrayC);
		if (sizeof($conceptArry)==1)
			$resultArrayC=highlightConcept($resultArrayC,$concept);
		else
			
			$resultArrayC=highlightMultipleConcept($resultArrayC,$concept);
		
		//echo '<pre>';
		//print_r($resultArrayC);
		//echo '</pre>';
		
		//include_once('./model/sortResults.php');
		include_once('./model/sortConceptResults.php');
		$sortedResultArrayC= aggregateConcept($resultArrayC,$collection);
		 
		$finalResultArrayC = array_merge($finalResultArrayC,$sortedResultArrayC);
		$finalDisplayArrayC = array_merge($finalDisplayArrayC,$valsC);
		array_multisort($finalDisplayArrayC, SORT_DESC);

		include_once('./model/extractMatchListFromArray.php');
		$matchSegmentArrayC = extractMatchListFromArray($finalResultArrayC);
				
				
		}// end of foreach $database loop	
		
		//echo '<pre>';
		//print_r($finalResultArrayC);
		//echo '<br>';
		//print_r($matchSegmentArray);
		//echo '</pre>';
		
		
		//if ( sizeof($finalResultArray) == 0 )
		//{
				//echo sizeof($finalResultArray);
				//echo '<pre>';
				//print_r($finalResultArray);
				//echo '</pre>';
				//$errorMessage='No search results are found. ';
				//include_once('./view/errorFile.php');
		//}
		
		//else{
		//	include_once('view/displaySearch.php');	
		//}
}
include_once('/model/combineKeywordConceptResult.php');
$resultArrayKC = ANDKeywordConcepts($resultArrayC,$resultArrayK);

//echo '<pre>';
//print_r($resultArrayKC);
//echo '</pre>';

$valsKC = array_count_values(array_column($resultArrayKC ,'docname'));
array_multisort($valsKC, SORT_DESC);


array_multisort($resultArrayKC);

//include_once('./model/sortConceptResults.php');
$sortedResultArrayKC= aggregateConcept($resultArrayKC,$collection);
 
$finalResultArray = array_merge($finalResultArray,$sortedResultArrayKC);
$finalDisplayArray = array_merge($finalDisplayArray,$valsKC);
array_multisort($finalDisplayArray, SORT_DESC);

//include_once('./model/extractMatchListFromArray.php');
$matchSegmentArray = extractMatchListFromArray($finalResultArray);

/*		
echo '<pre>';
echo '<br> <b>Showing Keyword final result array</b>';
print_r($resultArrayK);
echo '<br>';
echo '<br> <b>Showing Concept final result array</b>';
print_r($resultArrayC);
echo '<br>';
echo '</pre>';
*/
if ( sizeof($finalResultArray) == 0 ){
		$errorMessage="No result found!";
		include_once('./view/errorFile.php');
}
else{
include_once('view/displaySearch.php');
}	
//else{
//	
//}
	

?>
