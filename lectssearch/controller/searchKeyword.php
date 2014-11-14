<?php

$keyword=$_POST['searchfield'];
$collList = $_GET['database'];

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
		$colDir = './database' ;
		$ext = '.xml';
		include_once('model/getFileList.php');
		$collList = getFileList($colDir,$ext);	
	}
	//print_r($colList);
	foreach ((array)$collList as $collection)
	{
			$collection = preg_replace('/\\.[^.\\s]{3,4}$/', '', $collection);
			//	1. Search from Lucene
			include_once('./model/searchLucene.php');
			$luceneOut = searchLucene($keyword,$collection);
			
			/* echo '<pre>';
			echo $collection. '</br>';
			print_r($luceneOut);
			echo '</pre>';  */
			 
			
			include_once('./model/getInfoFromSearch.php');
			$resultArray = getInfoFromSearch($luceneOut);
				
			/* echo '<pre>';
			echo 'Printing resultArray after getInfoFromSearch '. $collection. '</br>';
			print_r($resultArray);
			echo '</pre>';  */
				
				
			$vals = array_count_values(array_column($resultArray,'docname'));
			array_multisort($vals, SORT_DESC); 
				
			
			include_once('./model/removeStopWords.php');
			$keyword = removeStopWords($keyword);
			$_SESSION['searchWord']= $keyword;	
	
			include_once('./model/highlightKeyword.php');
		
			$resultArray=highlightKeyword($resultArray,$keyword);
	
			/* if (sizeof($resultArray) > 0){
				foreach ($resultArray as $key => $row) {
					$docname[$key]  = $row['docname'];
					$word[$key] = $row['word'];
				}
				array_multisort($docname, SORT_ASC, $word, SORT_ASC, $resultArray);
			}	 */		

			 
			
			array_multisort($resultArray);
			
			/* echo '<pre>';
			echo 'Printing resultArray after highlightKeyword and multisort'. $collection. '</br>';
			print_r($resultArray);
			echo '</pre>'; */
			
			include_once('./model/sortResults.php');
			$sortedResultArray= aggregate($resultArray,$collection);
			
			/* echo '<pre>';
			echo 'Printing sortedResultArray after sorting resultArray </br>';
			print_r($sortedResultArray);
			echo '</pre>'; */
			
				 
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
		
		// prepare Coordinate
		include_once('model/prepareCoordinate.php');
		$arrayCord=  array();
		$arrayCord = prepareCoordinate($finalResultArray);
		
		
		
		
		include_once('view/displaySearch.php');	
		/* echo 'Printing finalResultArray and $Coordinate array <pre>';
		print_r($finalResultArray);
		print_r($arrayCord);
		echo '</pre>';  */
		}
}
else{
	$errorMessage="Enter a keyword in the search box";
	include_once('./view/errorFile.php');
}
	

?>