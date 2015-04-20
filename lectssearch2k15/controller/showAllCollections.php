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
 * @author Kyaw Zin Tun (c) 2015
 */
$dir='./collections';
$extension='.xml';
	
if (is_dir($dir)){
	// get collection file list
	include_once('model/getFileList.php');
	$fileList=getFileList($dir, $extension);
	
	if ( $fileList == 0 ){
		$errorMessage="[ERROR 1]: no collection found in $dir";
		include_once('view/errorFile.php');
	}
	else{
		$collections= array();
		//get info from collections
		include_once('model/getMetadataFromXmlCollection.php');
		include_once('model/loadXML.php');
		
		foreach($fileList as $file){
			$xmlCollection = loadXML($file);
			$compiledInfo = getMetadataFromXmlCollection($xmlCollection);
			$collections[$compiledInfo['name']] = $compiledInfo;
		}
		
		
		// display all collections using $collections
		include_once('view/displayAllDB.php');
	}	
}
else{
	$errorMessage="problem with database directory";
	include_once('view/errorFile.php');
}
