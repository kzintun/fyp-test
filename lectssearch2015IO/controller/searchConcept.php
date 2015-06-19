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
//$concept=$_POST['searchfield'];
if (!isset( $_GET['database']))
	$database = "all";
else
	$database = $_GET['database'];
	$concept = $_GET['concept'];

if (isset($concept)){
	
	//initialize
	$resultArray = array();
	$resultArray1 = array();
	$resultArray2 = array();
	$sortedResultArray = array();
	$finalResultArray = array();
	$finalDisplayArray = array();
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
		
		//	----------------------------- 1. Search from concept XML database -------------------------------//
		
		include_once('./model/searchConceptXML.php');
		//$xmlOut = searchConceptXML($concept, $conceptXMLFile);
		$xmlOut = searchConceptXML($conceptArry[0], $conceptXMLFile);
	
		//	----------------------------- 2. Extract info from xml output -------------------------------//
	
		include_once('./model/getInfoFromConceptSearch.php');
		$resultArray = getInfoFromConceptSearch($xmlOut);
		
		//include_once('./model/highlightConcept.php');
		//$resultArray=highlightConcept($resultArray,$conceptArry[0]);
		if (sizeof($conceptArry) > 1)
		{
			
		//	----------------------------- 3. Perform logical AND operation on multiple concepts search -------------------------------//	
			
			include_once('./model/compareConceptAND.php');
	
			for ($i=1 ; $i< sizeof($conceptArry); $i++)
			{
				
				$xmlOut2 = searchConceptXML($conceptArry[$i], $conceptXMLFile);
				
				$resultArray2 = getInfoFromConceptSearch($xmlOut2);
			
				//$resultArray2=highlightConcept($resultArray2,$conceptArry[$i]);
				
				$resultArray = compareConcepts($resultArray,$resultArray2);
			
			}
		}

		array_multisort($resultArray);
				
				
		$vals = array_count_values(array_column($resultArray,'docname'));
		array_multisort($vals, SORT_DESC);
					
					
		//	----------------------------- 4. Add a tooltip to each concepts' keyword -------------------------------//	
		
		include_once('./model/highlightConcept.php');
		if (sizeof($conceptArry)==1)
			$resultArray=highlightConcept($resultArray,$concept);
		else
			$resultArray=highlightMultipleConcept($resultArray,$concept);
		
		//echo '<pre>';
		//print_r($resultArray);
		//echo '</pre>';
		
		
		//	----------------------------- 5. Restructure the result array by distinct document name -------------------------------//
		
		include_once('./model/sortConceptResults.php');
		$sortedResultArray= aggregateConcept($resultArray,$collection);
		
		//	----------------------------- 5. Get the total no. of documents inside each collection -------------------------------//	
		include_once("model/loadXML.php");
		$xmlFile='./collections/'.$collection.'.xml';
		$xml=loadXML($xmlFile);
			
		include_once("model/getMetadataFromXmlCollection.php");
		$docInfo=getMetaDataFromXmlCollection($xml);
			
		//	----------------------------- 6. Compute TF-IDF of each document -------------------------------//
		include_once('model/newRankSort.php');
		//$finalResultArray = sortRank($finalResultArray, $collection, $docInfo,$finalDisplayArray);
		$sortedResultArray = sortConceptRank($sortedResultArray, $collection, $docInfo, $treeTable, $concept);
		
		$finalResultArray = array_merge($finalResultArray,$sortedResultArray);
		$finalDisplayArray = array_merge($finalDisplayArray,$vals);
		array_multisort($finalDisplayArray, SORT_DESC);
		
		
				
				
		}// end of foreach $database loop	
		
	
		if ( sizeof($finalResultArray) == 0 )
		{
				$errorMessage='No search results are found. ';
				include_once('./view/errorFile.php');
		}
		
		else{
		// ----------------------------- 7. Rank the documents by TF-IDF score -------------------------------//
			
			foreach ($finalResultArray as $key => $row) {
				$rank[$key] = $row['score']['tfidf'];
			}
			array_multisort($rank, SORT_DESC, $finalResultArray);
		
			include_once('./model/extractMatchListFromArray.php');
			$matchSegmentArray = extractMatchListFromArray($finalResultArray);
		
			include_once('view/displaySearch.php');	
		}
}
else{
	$errorMessage="Enter a concept in the search box";
	include_once('./view/errorFile.php');
}
	

?>