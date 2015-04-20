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
	
	//	initialize
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
		
		include_once('./model/searchConceptXML.php');
		//$xmlOut = searchConceptXML($concept, $conceptXMLFile);
		$xmlOut = searchConceptXML($conceptArry[0], $conceptXMLFile);
	
		include_once('./model/getInfoFromConceptSearch.php');
		$resultArray = getInfoFromConceptSearch($xmlOut);
		
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
				$resultArray2 = getInfoFromConceptSearch($xmlOut2);
				//echo '<pre>';
				//print_r($resultArray2);
				//echo '</pre>';
				$resultArray = compareConcepts($resultArray,$resultArray2);
				
			}
		}

		array_multisort($resultArray);
				
				
		$vals = array_count_values(array_column($resultArray,'docname'));
		array_multisort($vals, SORT_DESC);
					
					
			
		include_once('./model/highlightConcept.php');
		$resultArray=highlightConcept($resultArray);
		
		//echo '<pre>';
		//print_r($resultArray);
		//echo '</pre>';
		
		//include_once('./model/sortResults.php');
		include_once('./model/sortConceptResults.php');
		$sortedResultArray= aggregate($resultArray,$collection);
		 
		$finalResultArray = array_merge($finalResultArray,$sortedResultArray);
		$finalDisplayArray = array_merge($finalDisplayArray,$vals);
		array_multisort($finalDisplayArray, SORT_DESC);

		include_once('./model/extractMatchListFromArray.php');
		$matchSegmentArray = extractMatchListFromArray($finalResultArray);
				
				
		}// end of foreach $database loop	
		
		//echo '<pre>';
		//print_r($finalResultArray);
		//echo '</pre>';
		
		
		if ( sizeof($finalResultArray) == 0 )
		{
				//echo sizeof($finalResultArray);
				//echo '<pre>';
				//print_r($finalResultArray);
				//echo '</pre>';
				$errorMessage='No search results are found. ';
				include_once('./view/errorFile.php');
		}
		
		else{
			include_once('view/displaySearch.php');	
		}
}
else{
	$errorMessage="Enter a concept in the search box";
	include_once('./view/errorFile.php');
}
	

?>