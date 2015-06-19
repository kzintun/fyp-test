<?PHP
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
 * @author Ong Jia Hui (c) 2015
 */
function calculateConcepts($collection){

 $conceptXMLFile = './conceptDir/'.$collection.".xml";
 $conceptCount = array();
 include_once("model/loadXML.php");
 $xml=loadXML($conceptXMLFile);
 //$xml=simplexml_load_file('./conceptDir/'.$conceptXMLFile);
if($xml !== 0){
	foreach ($xml->children() as $concept) {
  
		foreach ($concept->children() as $keyword) {
	
			if (!isset($conceptCount[(String)$concept['id']][(String)$keyword['docName']]))
			{
				$conceptCount[(String)$concept['id']][(String)$keyword['docName']] = 1;
			}
			else
			{
				$conceptCount[(String)$concept['id']][(String)$keyword['docName']]++; 
			}
		}
    }
}
//echo '<pre>';
//print_r($conceptCount);
//echo '</pre>';
 if(empty($conceptCount)) {
 	$conceptCount = null;
 }
 return $conceptCount;
}
?>