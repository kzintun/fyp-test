<?php

//$keyword=$_POST['searchfield'];
if (!isset( $_GET['database']))
	$collList = "all";
else
	$collList = $_GET['database'];
$keyword = $_GET['keyword'];

if (isset($keyword)){
	
	//	initialize
	$resultArray = array();
	$sortedResultArray = array();
	$finalResultArray = array();
	$finalDisplayArray = array();
	
	// GET database/collection name here (currently hard-coded)
	//$collection = 'aerospace';
	
	
	
	if ($collList == 'all')
	{
		//echo $collList;
		$colDir = './collections' ;
		$ext = '.xml';
		include_once('model/getFileList.php');
		$collList = getFileList($colDir,$ext);	
	}
	//print_r($colList);
	foreach ((array)$collList as $collection)
	{
			//echo $collList;
			$collection = preg_replace('/\\.[^.\\s]{3,4}$/', '', $collection);
			//	1. Search from Lucene
			include_once('./model/searchLucene.php');
			$luceneOut = searchLucene($keyword,$collection);
			
	
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
				
				/* echo '<pre>';
				echo '</br>';
				print_r($sortedResultArray);
				//print_r($finalDisplayArray);
				
				
				print_r($finalDisplayArray);
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
	}	// end of foreach $collList loop	
		
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