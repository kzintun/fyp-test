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
			
			$collection = preg_replace('/\\.[^.\\s]{3,4}$/', '', $collection);
			//	----------------------------- 1. Search from Lucene -------------------------------//
			include_once('./model/searchLucene.php');
			$luceneOut = searchLucene($keyword,$collection);
			
	
			/* if ( sizeof($luceneOut) == 1 ){
				
				 
				$value = $luceneOut[0];
				$errorMessage='No search results are found in ' .$collection.'</br>Error Details: '. $value;
				
				include_once('./view/errorFile.php');
			}
			else{ */
			
			//	----------------------------- 2. Extract info from Lucene output -------------------------------//
			
			include_once('./model/getInfoFromSearch.php');
			$resultArray = getInfoFromSearch($luceneOut);
				
			//	echo '<pre>';
				//print_r($luceneOut);
				//echo '</br>';
				//print_r($resultArray);
				//echo '</pre>'; 
				
			array_multisort($resultArray);
				
				//print_r($resultArray);
				//echo '</pre>';
				
			$vals = array_count_values(array_column($resultArray,'docname'));
			array_multisort($vals, SORT_DESC);
				
			
			//	----------------------------- 3. Remove stopwords(for keyword 'OR' search) and Highlight search terms  -------------------------------//
			include_once('./model/highlightKeyword.php');
			if (preg_match('/^(["\']).*\1$/m', $keyword))
			{
				$newkeyword = $keyword;
				$resultArray=highlightKeywordPhrase($resultArray,$newkeyword);
			}
			else
			{
				include_once('./model/removeStopWords.php');
				$newkeyword = removeStopWords($keyword);
				$resultArray=highlightKeyword($resultArray,$newkeyword);
			}
			
			//	----------------------------- 4. Restructure the result array by distinct document name -------------------------------//
			include_once('./model/sortResults.php');
			$sortedResultArray= aggregate($resultArray,$collection);
			
			//echo '<pre>';
			//print_r ($vals);
			//echo '</pre>';
			
			//$finalResultArray = array_merge($finalResultArray,$sortedResultArray);
			//$finalDisplayArray = array_merge($finalDisplayArray,$vals);
				
			//echo '<pre>';
			//print_r ($finalDisplayArray);
			//echo '</pre>';
				
			array_multisort($finalDisplayArray, SORT_DESC);
			
			//	----------------------------- N. Unknown (last step)-------------------------------//
			//include_once('./model/extractMatchListFromArray.php');
			//$matchSegmentArray = extractMatchListFromArray($finalResultArray);
			
			//	----------------------------- 5. Get the total no. of documents inside each collection -------------------------------//	
			include_once("model/loadXML.php");
			$xmlFile='./collections/'.$collection.'.xml';
			$xml=loadXML($xmlFile);
				
			include_once("model/getMetadataFromXmlCollection.php");
			$docInfo=getMetaDataFromXmlCollection($xml);
				
			//	----------------------------- 6. Compute TF-IDF of each document -------------------------------//
			include_once('model/newRankSort.php');
			//$finalResultArray = sortRank($finalResultArray, $collection, $docInfo,$finalDisplayArray);
			$sortedResultArray = sortRank($sortedResultArray, $collection, $docInfo,$vals, $newkeyword);
			
			$finalResultArray = array_merge($finalResultArray,$sortedResultArray);
			$finalDisplayArray = array_merge($finalDisplayArray,$vals);
			//echo '<pre>';
	}	// end of foreach $database loop	
		
		if ( sizeof($finalResultArray) == 0 )
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
		
			// ----------------------------- 7. Rank the documents by TF-IDF score -------------------------------//
			
			foreach ($finalResultArray as $key => $row) {
				
				$rank[$key] = $row['score']['tfidf'];
			}
			array_multisort($rank, SORT_DESC, $finalResultArray);
			//echo '<pre>';
			//print_r ($finalResultArray);
			//echo '</pre>';
			
			//	----------------------------- N. Prepare for some components of View (last step)-------------------------------//
			include_once('./model/extractMatchListFromArray.php');
			$matchSegmentArray = extractMatchListFromArray($finalResultArray);
			
			include_once('view/displaySearch.php');	
			
		}
}
else{
	$errorMessage="Enter a keyword in the search box";
	include_once('./view/errorFile.php');
}
	

?>