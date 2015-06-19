<!--
<html>
<head>
<title>Test page</title>
</head>
<body>

  
        <FORM NAME ="form1" METHOD ="GET" ACTION = "test.php">

		<INPUT TYPE = "TEXT" Name = "word" VALUE ="Enter word">
		<INPUT TYPE = "Submit" Name = "Submit1" VALUE = "Check">

		</FORM>
   



</body>
</html>
-->

<?php
// ----------------- This is a code testing script --------------------------------//

// ------------------------Test A-------------------------------------------------//

function getGoogleSuggestions($query){
	$file = file_get_contents("http://www.google.com/search?q=".urlencode($query));	
		//print_r($file);
		//if (strpos($file,'Showing results for')=== false)
			$ex0 = explode('Showing results for', $file);
			//print_r(count($ex0));
			if (count($ex0)==1){
			//echo '<br>here<br>';
			$ex0 = explode('Did you mean:', $file);
			}
			//print_r(count($ex0));
			//print_r($ex0[1]);
			if (count($ex0)!=1){
		//$ex0 = explode('Did you mean:', $ex00[1]);
		//$ex0 = preg_split({'Showing results for','Did you mean:'},$file);
		//print_r(count($ex0));
		echo '<pre>';
		//print_r($ex0[1]);
		echo '</pre>';
		$ex1 = str_replace('</i></b>', '<b><i>', $ex0[1]);
		//print_r($ex1);
		$ex2 = explode("<b><i>", $ex1);
		echo '<pre>';
		print_r($ex2); //if error ,check this array
		echo '</pre>';
		if (isset($ex2[1]))
		return "Did you mean: ".$ex2[1];
		}
		return '<br>Query: '.$query . ' 	cannot be found. ';
}

// --------------------------Test B-----------------------------------------------------//

// use this for singleword suggestions (no space single word)
function getGoogleSuggestions1($query){
	$suggestion=" ";	
	$file = file_get_contents("http://www.google.com/search?q=".urlencode($query));
		//print_r($file);
		if (strpos($file,'Showing results for')!== false){
			echo 'showing results for--<br>';
			$ex0 = explode('Showing results for', $file);
			}
			//print_r(count($ex0));
		else if (strpos($file,'Did you mean:')!== false){
			echo '<br>Did you mean ---<br>';
			echo strpos($file,'Did you mean:');
			$ex0 = explode('Did you mean:', $file);
			}
		else{
			return '<br>Query: '.$query . ' 	cannot be found. ';
			}
			//print_r(count($ex0));
		//	print_r($ex0);
			if (count($ex0)!=1){
		//$ex0 = explode('Did you mean:', $ex00[1]);
		//$ex0 = preg_split({'Showing results for','Did you mean:'},$file);
		//print_r(count($ex0));
		echo '<pre>';
		//print_r($ex0[1]);
		echo '</pre>';
		$ex1 = str_replace('</i></b>', '<b><i>', $ex0[1]);
		//print_r($ex1);
		$ex2 = explode("<b><i>", $ex1);
		echo '<pre>';
		print_r(sizeOf($ex2)); //if error ,check this array
		print_r($ex2); //if error ,check this array
		echo '</pre>';
		for($i=0; $i<sizeOf($ex2)-1; $i++)
			{
				echo 'size of array '.$i . ' is ' . strlen($ex2[$i]) .'<br>';
				$ex2[$i]=strip_tags($ex2[$i]);
				echo 'size of array '.$i . ' is ' . strlen($ex2[$i]) .'<br>';
			//if ( strip_tags($ex2[$i]) ==='Search instead for ')
			if (strpos($ex2[$i],'Search') && strpos($ex2[$i],'instead')&& strpos($ex2[$i],'for'))
			{
			echo $ex2[$i].' here1' . strlen($ex2[$i]).'<br>';
			break;
			}
			else if (sizeOf($ex2[$i]) ==1){
				
				echo 'Adding '. strip_tags($ex2[$i]).' to suggestion<br>';
				$suggestion.=strip_tags($ex2[$i]).' ';
				//echo $suggestion;
			}
			
			else if (sizeOf($ex2[$i])>1 && isset($ex2[$i]))
			{
			echo 'here 2';
			break;
			}
			}
		if (isset($ex2[1]))
		return "<br>Did you mean: ".$ex2[1] . ' or ' . $suggestion;
		}
		return '<br>Query: '.$query . ' 	cannot be found. ';
	
}

// -----------------------Test C----------------------------------------------------//

// use this for multiple word suggestions (not accurate for 'Showing results for')
function getGoogleSuggestions2($query){
	$lang = 'en';


	$url = 'http://suggestqueries.google.com/complete/search?output=firefox&client=firefox&hl=' . $lang . '&q=' . urlencode($query);

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.0; rv:2.0.1) Gecko/20100101 Firefox/4.0.1");
	$data = curl_exec($ch);
	curl_close($ch);

	$suggestions = json_decode($data, true);

	if ($suggestions) {
		echo 'suggestions: ';
		print_r($suggestions);
		} 
	else {
		echo 'no suggestion';
		}
}

// ---------------------------------Test D----------------------------------------------------//

function getGoogleSuggestions3($query){
	$lang = 'en';


	// pretend we're an ordinary browser
	$agents = array(
		"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/11.0.696.60 Safari/534.24",
		"Opera/9.63 (Windows NT 6.0; U; ru) Presto/2.1.1",
		"Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5",
	);

	// create the url. $lang is very important parameter because it specifies in what language
	// we are searching and therefore it influences the search results a lot.
	$url = 'http://www.google.com/search?client=firefox-a&hl=' . $lang . '&q=' . urlencode($query);

	// download the search results
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, $agents[rand(0, count($agents) - 1)]);
	$data = curl_exec($ch);
	curl_close($ch);

	// span with class 'spell' means that Google suggested something
	$template_span = '<span class=spell ';
	$template_a = '<a rel="nofollow" target="blank" href';
	$template_end_a = '</a>';

	// check if the html source code contains "did you mean" block
	if (strpos($data, $template_span) === false) {
		$answer = false;
	} else {
		$str = substr($data, strpos($data, $template_span));
		$str = substr($str, strpos($str, $template_a));
		// and here's the Google's suggestion
		$answer = strip_tags(substr($str, 0, strpos($str, $template_end_a)));
}

	if ($answer) {
		echo 'did you mean: ' . $answer;
	} else {
		echo 'no suggestion';
	}
}
// ------------------------------Test E-------------------------------------------//

function checkSpelling(){
	if (isset($_GET['word']))
	{
		$keyword = $_GET['word'];
		echo $keyword .'<br>';
		$collection = 'signalprocessing';
		include_once('./model/checkSpelling.php');
		$message = checkSpelling($keyword, $collection);
		print_r($message);
	}
}


// -------------------------Test F-----------------------------------------------//

function callLucene($numCollection){
	
	switch ($numCollection) {
    case 1:
        $collections = array ('signalprocessing');
        break;
    case 2:
        $collections = array ('aerospace','signalprocessing');
        break;
    case 3:
        $collections = array ('signalprocessing','aerospace','tedtalk');
        break;
}
	$query = "transform";
	
	include_once('./model/searchLucene.php');
	foreach ($collections as $collection)
	{
		echo $query . ' ' . $collection . '<br>';
		$luceneOut = searchLucene($query, $collection);
		echo '<pre>';
		print_r($luceneOut);
		echo '</pre>';
	}
	//echo '<pre>';
	//print_r($luceneOut);
	//echo '</pre>';
	
}
// ----------------------------------------------------------------------------//

// --------------------------MAIN METHOD--------------------------------------//
$time = microtime(true); // time in Microseconds
callLucene(3);
echo '<br>'.(microtime(true) - $time) . ' elapsed';


?>


