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
 * @author Ong Jia Hui (c) 2015
 */
if(isset($_GET['document'])) $document=html_entity_decode($_GET['document']);
else $document = null;
if(isset($_GET['database'])) $database=html_entity_decode($_GET['database']);
else $database = "all";

$xmlLoc = './suggestionDir/suggestions.xml';

if (file_exists($xmlLoc)) {
	include_once("model/loadXML.php");
	$xml=loadXML($xmlLoc);

	include_once("model/getSuggestionsFromXML.php");
	$rawSuggestionList = getSuggestionsFromXML($xml, $database, $document);

	if ($rawSuggestionList != null) {
		include_once("model/rankSuggestions.php");
		$rankedSuggestionList = rankSuggestions($rawSuggestionList);
		//include_once("model/extractFinalSuggestionList.php");
		//$rankedSuggestionList = extractFinalSuggestionList($rankedSuggestionList);
	}
	else {
		$rankedSuggestionList = array();
	}
	//print_r($rankedSuggestionList);

}
else {
	return false;
}
