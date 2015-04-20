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
 */
//Created on 18/10/2014 by JH-->
//Modlfied on 14/11/10/2014 by BB-->
function getMetadataFromXmlDocument($xml){
	
	//~ Improvement could be to load directly the attributes
	// input: instance of the xml document
	// output: table with metada
		
	$docInfo = array();
	
	$docName = (string) $xml->attributes()->name;
	
	foreach ( $xml->metadata as $t ){
		
		$docInfo['xmlLoc']='./documents/'. $docName . '.xml';		
		$docInfo['description']= (string) $t->description;
		$docInfo['media']='./documents/'. (string) $t->media->attributes()->name ;
		$docInfo['type'] = (string) pathinfo($t->media->attributes()->name , PATHINFO_EXTENSION);
		$docInfo['speaker'] = array();		
		
		foreach ( $t->speakers->speaker as $spk){	
			$currSpk = (string) $spk->attributes()->name;
			if (preg_match("/unknown_/" , $currSpk )){
				$currSpk = (string) "unknown";
			}
			
			$currId  =  (int) $spk->attributes()->id;
			$docInfo['speaker'][(int) $currId] = $currSpk;
		}	
		$docInfo['speakerEdit'] = join(', ', $docInfo['speaker'] );
				
	}	
	//print_r($docInfo);
	return $docInfo;
}

