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

// input = subject array , keywords array
// output = subject array with keywords bol
// highlight the keywords
function highlightKeyword($haystackArray, $keyword) {
	$keywordList = explode(" ", $keyword);
	for ($k=0 ; $k < sizeof($haystackArray); $k++){
			foreach($keywordList as $word){
			
				$haystack= $haystackArray[$k]['text'];
				$needle= $word;
				
				// return $haystack if there is no strings given, nothing to do.
				if (strlen($haystack) < 1 || strlen($needle) < 1) {
				}
				else{
				preg_match_all("/\b$needle+\b/i", $haystack, $matches);
				
				if (is_array($matches[0]) && count($matches[0]) >= 1) {
					foreach ($matches[0] as $match) {
						$haystack= str_replace($match, '<b>'.$match.'</b>', $haystack);
					}
				$haystackArray[$k]['word'] .= $match . " ";	
				}
				$haystackArray[$k]['text'] = $haystack;
				
				}
			}
			
	}
    return $haystackArray;
}
?>