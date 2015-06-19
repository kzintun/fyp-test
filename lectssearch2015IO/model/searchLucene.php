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

//set_time_limit(0);
	// Description: pass a keyword to java file and retrieve the string array
	//		   	  : Look into 'indexDir' index directory and return the list of ids result
	//	input = String keyword/search query, String name of collection/database
	//	output = multiple lines of output from lucene stored in an array	
	//~ java -jar queryDB.jar "engine" MIT_Aerospace
	
	// require error handling for wrong $pathJar
	function searchLucene($keyword, $collection){
	
	//  Check normal or phrase search
	//	1. Set Jar file path
	if (preg_match('/^(["\']).*\1$/m', $keyword))
	{
		
		$pathJar = './luceneJar/searchLucenePhrase.jar';
	}
	else{
	
	$pathJar = './luceneJar/searchLucene.jar';
	}
	//echo $keyword . ' ' . $collection .' '. $pathJar . '<br>';
	//	2. Execute Jar file with input keyword
	$javaOutput = exec ('java -jar ' . $pathJar . ' ' . $keyword . ' ' . $collection, $luceneOut);
	
	//echo'<pre>';
	//print_r($luceneOut);
	//echo '</pre>';
	if ( $luceneOut[0] == "the database does not exits" ){		
		return -1;
	}
	
	return $luceneOut;
}
