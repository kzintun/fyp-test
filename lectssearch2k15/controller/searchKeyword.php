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
//$keyword=$_POST['searchfield'];
if (!isset( $_GET['database']))
	$database = "all";
else
	$database = $_GET['database'];
$keyword = $_GET['keyword'];

if (isset($keyword)){
	
	//	initialize
	$resultArray = array();
	$sortedResultArray = array();
	$finalResultArray = array();
	$finalDisplayArray = array();
	
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
				$resultArray = getInfoFromSearch($luceneOut);
				
				
				
				array_multisort($resultArray);
				
				
				$vals = array_count_values(array_column($resultArray,'docname'));
				array_multisort($vals, SORT_DESC);
				
			
				include_once('./model/removeStopWords.php');
				$keyword = removeStopWords($keyword);
					
			
				include_once('./model/highlightKeyword.php');
		
				$resultArray=highlightKeyword($resultArray,$keyword);
		
				include_once('./model/sortResults.php');
				$sortedResultArray= aggregate($resultArray,$collection);

				
				 
				 
				$finalResultArray = array_merge($finalResultArray,$sortedResultArray);
				$finalDisplayArray = array_merge($finalDisplayArray,$vals);
				array_multisort($finalDisplayArray, SORT_DESC);

				include_once('./model/extractMatchListFromArray.php');
				$matchSegmentArray = extractMatchListFromArray($finalResultArray);
				//$_SESSION['matchSegmentArray'] = $matchSegmentArray;
				//$_SESSION['keyword'] = $keyword;
				//print_r($finalDisplayArray);
				

				
				/*echo '<pre>';
				echo '</br>';
				//print_r($sortedResultArray);
				//print_r($finalDisplayArray);
				
				
				print_r($finalResultArray);
				print_r($matchSegmentArray);
				echo '</pre>'; */
				// Printing the contents of sorted result array (Array C)
				/*   foreach ($sortedResultArray as $key => $value){
					echo '</br>Document Name: <u>'.$key . '</u></br>';
					for ($k=0 ; $k < sizeof($value); $k++){
						echo '</br>';
						echo 'SegmentID: '.$value[$k]['segmentID'] . '</br>';
						echo 'SpeakerID: '.$value[$k]['speakerID'] . '</br>';
						echo 'SentenceID: '.$value[$k]['sentenceID'] . '</br>';
						echo 'StartTime: '.$value[$k]['startTime'] . '</br></br>';
						echo 'Text: '.$value[$k]['text'] . '</br>';
						echo 'Collection: '.$collection . '</br></br>';
						} 
				}  */
				// ----------------- block end ----------------------------------------
				 /* 7.	Pass to VIEW page
				 ** To be implemented next ** */
				
			//}	
	}	// end of foreach $database loop	
		
		if ( sizeof($finalResultArray) == 0 )
		{
				//echo sizeof($finalResultArray);
				//print_r($finalResultArray);
				$errorMessage='No search results are found. ';
				include_once('./view/errorFile.php');
		}
		
		else{
		include_once('view/displaySearch.php');	
		/* echo '<pre>';
		print_r($finalDisplayArray);
		echo '</pre>'; */
		}
}
else{
	$errorMessage="Enter a keyword in the search box";
	include_once('./view/errorFile.php');
}
	

?>