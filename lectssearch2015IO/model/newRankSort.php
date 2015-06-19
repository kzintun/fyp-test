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

//	input = necessary variables to compute TF-IDF
//	output = final result array with TF-IDF score appended for each document.



// --------------------- Calculation of TF-IDF ------------------------------
// tf-idf = (1+ log(tf)) * log(1+ (D[c] / D[c][t]))
//				tf part  *        idf part

function sortRank($srList,$collection,$docInfo,$countArray,$keyword){
	
	
	$Dc  = sizeOf($docInfo);
	$Dct = sizeOf($countArray);
	$termFreq = 0;
	
	$aggregated = array();
	$counter = 0;
	
	//foreach ($countArray as $key => $count)
	//{	
		
	//	$termFreq = (float)$count;
	//	$tfidf = (1 + log10($termFreq)) * log10( 1 + ($Dc / $Dct));
	//	$srList[$key]['score'] = $tfidf;
	//}
	
	foreach($srList as $key => $rvalue){
		//	echo 'Document : '. (sizeOf($rvalue)) .'<br><pre>';
		//print_r($rvalue);
		//echo'</pre>';
			foreach ($rvalue as $result){
				
				$tf = 0;
				// ***** Count the occurrences of keyword in each sentence and sum them all to computer Term frequency of the document ******//
				$text = $result['text'];
				$words = array_count_values(str_word_count($text, 1));
				arsort($words);
				$keywordList = explode(" ",$result['word']); // $result ['word '] = search keyword found in the sentence
				
				foreach ($keywordList as $singleTerm){
					if (isset($words[$singleTerm]))
					{
						$tf += $words[$singleTerm];
						$termFreq += (int)$words[$singleTerm];
					}
				}
				$srList[$key][$counter]['tf'] = $tf;
				$counter++;
				//$counter+= $result['rank'];
			}
		$tfidf = (1 + log10((float)$termFreq)) * log10( 1 + ($Dc / $Dct));
		//$srList[$key]['score'] = $tfidf;
		$srList[$key]['score']['tfidf'] = $tfidf;
		$srList[$key]['score']['tf'] = $termFreq;
		$srList[$key]['score']['idf'] = log10( 1 + ($Dc / $Dct));
		$termFreq = 0;
		$counter = 0;
		
	}
	//echo '<pre>';
	//print_r($srList);
	//echo '</pre>';
	return $srList;
  
}

function sortConceptRank($srList,$collection,$docInfo,$conceptCount,$concept){
	
	
	$conceptList = explode(", ",$concept);
	$Dc  = sizeOf($docInfo); // fixed for each collection
	$Dctt = sizeOf($srList);
	
	//echo $Dct;
	$termFreq = 1;
	
	$aggregated = array();
	$counter = 1;
	
	
	foreach($srList as $key => $rvalue){
		$tf = sizeOf($srList[$key]);
		$tfidf = (1 + log10((float)$tf)) * log10( 1 + ($Dc / $Dctt));
	
		
		$srList[$key]['score']['tfidf'] = $tfidf;
		$srList[$key]['score']['tf'] = $tf;
		$srList[$key]['score']['idf'] = log10( 1 + ($Dc / $Dctt));
		$termFreq = 0;
		$counter = 0;
	}
	
	return $srList;
  
}
			