
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
function getMetadataFromXmlCollection($xml){
	//~ Improvement could be to load directly the attributes
	$docInfo = array();
	foreach ( $xml->document as $t ){
		$docName = $t->attributes()->name;
		//~ echo $docName;
		$docInfo[(string) $docName]['xmlLoc']='./documents/'. $docName . '.xml';		
		$docInfo[(string) $docName]['description']=$t->metadata->description;
		$docInfo[(string) $docName]['media']='./documents/'. $t->metadata->media->attributes()->name ;
		$docInfo[(string) $docName]['type'] = pathinfo($t->metadata->media->attributes()->name , PATHINFO_EXTENSION);
		$docInfo[(string) $docName]['speaker'] = array();		
		
		foreach ( $t->metadata->speakers->speaker as $spk){	
			$currSpk = (String) $spk->attributes()->name;
			$currId  =  (int) $spk->attributes()->id;
			if (preg_match("/unknown_/" , $currSpk )){
				$currSpk = (string) "unknown";
			}
			$docInfo[(string) $docName]['speaker'][(int) $currId] = $currSpk;
		}	
		$docInfo[(string) $docName]['speakerEdit'] = join(', ', $docInfo[(string) $docName]['speaker'] );	
	}
	return $docInfo;
}



	
		
