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
 * @author Kyaw Zin Tun (c) 2015
 */

// input = subject array 
// output = subject array with concept keywords bold
// highlight the keywords
function highlightConcept($haystackArray,$conceptID) {
	
	//echo '<pre>';
	//for ($k=0 ; $k < sizeof($haystackArray); $k++){
	foreach ($haystackArray as $key => $hay){
	
		$wordArry = explode(" ", $hay['text']);
		$startWIndex = $hay['swID'];
		$endWIndex = $hay['ewID'];
		
		//echo $startWIndex . ' - ' . $endWIndex .'<br>';
		//print_r($wordArry);
		
		//for ($i=$startWIndex; $i<= $endWIndex ; $i++){
		//	$wordArry[$i] = '<b>'.$wordArry[$i].'</b>';
			
			//$wordArry[$i] = '<a title="This will appear on a hover">'.$wordArry[$i].'</a>';
			//$newtext = preg_replace("/\b$needle\b/", '<a title="This will appear on a hover">'.$needle.'</a>', $haystack);
		//	$wordArry[$i] = '<b> '.$wordArry[$i].' </b>';
			//echo $wordArry[$i] .' ';
		
		//}
		//echo '<pre>';
		//print_r ($wordArry);
		//echo '<br>SWID: ' . $startWIndex . ' EWID: ' . $endWIndex . '<br>'; 
		$wordArry[$startWIndex] = '<a data-toggle="tooltip" data-placement="top" title="'.$conceptID.'" class="red-tooltip">'.$wordArry[$startWIndex];
		//print_r($wordArry);
		$wordArry[$endWIndex] = $wordArry[$endWIndex].'</a>';
		// shorten the length of the sentence to 16 words
		//print_r($wordArry);
		//echo '</pre>';
		$haystackArray[$key]['text'] = implode(" ",$wordArry);
		//preg_match_all('((?:\S+\s*){0,7}'.$wordArry[$startWIndex].'(?:\s*\S+){0,7})',$haystackArray[$key]['text'],$matches); correct ver
		
		//((?:\S+\s*){0,5}name(?:\s*\S+){0,5})
		//preg_match_all('/(?:\S+\s*){0,7}\S*'.$wordArry[$startWIndex].'\S*(?:\s*\S+){0,7}/s',$haystackArray[$key]['text'],$matches);
		//var_dump($wordArry[$startWIndex]);
		//var_dump($matches[0][0]);
		
		//$haystackArray[$key]['text'] = $matches[0][0];
		
		//echo $hay['text'] . ' ';
	}
	//echo '</pre>';
    return $haystackArray;
}
function highlightMultipleConcept($haystackArray,$conceptID) {
	
	$sameKeywordFlag = false;
	
	foreach ($haystackArray as $key => $hay){
	
		$wordArry = explode(" ", $hay['text']);
		$startIDArray = explode (" ", $hay['swID']);
		$endIDArray = explode (" ", $hay['ewID']);
		$conceptArray = explode (", ", $conceptID);
		//$startWIndex = $hay['swID'];
		//$endWIndex = $hay['ewID'];
		
		if (sizeof($startIDArray) > 1 || sizeof($endIDArray) > 1){
			for ($i = 0; $i < sizeof($startIDArray)-1 ; $i++){
				if ($startIDArray[$i] == $startIDArray[$i+1] && $endIDArray[$i] == $endIDArray[$i+1])
					$sameKeywordFlag = true;
				else{
					$sameKeywordFlag = false;
					break;
				}
			}
		}
		
		// if both concept share same keyword, 
		if ($sameKeywordFlag== true)
		{	
			//echo '<pre>';
			//print_r($hay);
			//print_r ($wordArry);
			//print_r($startIDArray);
			//echo '<br>'.$startIDArray[0] . ' ' . $wordArry[$startIDArray[0]] .'<br>';
			//echo $endIDArray[0] . ' ' . $wordArry[$endIDArray[0]] .'<br>';
			//echo '</pre>';
			$wordArry[$startIDArray[0]] = '<a data-toggle="tooltip" data-placement="top" title="'.$conceptID.'" class="red-tooltip">'.$wordArry[$startIDArray[0]];
			$wordArry[$endIDArray[0]] = $wordArry[$endIDArray[0]].'</a>';
		}
		// shorten the length of the sentence to 16 words
		else{
			//echo 'do something here';
			for ($i = 0; $i < sizeof($startIDArray) ; $i++){
				$wordArry[$startIDArray[$i]] = '<a data-toggle="tooltip" data-placement="top" title="'.$conceptArray[$i].'" class="red-tooltip">'.$wordArry[$startIDArray[$i]];
				$wordArry[$endIDArray[$i]] = $wordArry[$endIDArray[$i]].'</a>';
			}
			
		}
		$haystackArray[$key]['text'] = implode(" ",$wordArry);
		//preg_match_all('((?:\S+\s*){0,7}'.$wordArry[$startWIndex].'(?:\s*\S+){0,7})',$haystackArray[$key]['text'],$matches);

		//$haystackArray[$key]['text'] = $matches[0][0];
		
		//echo $hay['text'] . ' ';
	}
	//echo '</pre>';
    return $haystackArray;
}
?>