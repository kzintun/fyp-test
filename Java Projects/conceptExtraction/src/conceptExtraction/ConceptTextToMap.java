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

package conceptExtraction;

// <---------------------------------1. Extract concept and keyword from text file ----------------------------------------->
// Read from concept annotation text file and  populate pairs into MultiMap

/**
 * @author Kyaw Zin Tun
 * @version 1.0
 */


import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Arrays;


import com.google.common.collect.ArrayListMultimap;
import com.google.common.collect.Multimap;

public class ConceptTextToMap {

	
	public static void main(String [] args) throws IOException{
		
		getConcept(); 
		
	}

	// Populate concept-key pair based on the input text from concept annotations
	// Store the pairs in Multi-Map structure
	/**
	 * This returns concept-keyword pairs for Signal Processing domain
	 * Read line from text file and extract terms (seperated by comma)
	 * Store into key-term1,key-term2,etc pairs
	 * @return
	 * @throws IOException
	 */
	public static Multimap getConcept() throws IOException
	{
		Multimap<String, String> ckMap = ArrayListMultimap.create();
		BufferedReader br = new BufferedReader(new FileReader("./conceptDir/DSPmatching.txt"));
		String line;
		String word,rest;
		String restword;
		
		while ((line = br.readLine()) != null) {
			
			// get the first word concept
			int ik = line.indexOf(' ');
			word = line.substring(0, ik);
			 
			// get the rest of the keywords associated to the concept
			restword = line.substring(line.indexOf("[") + 1, line.indexOf("]"));
			 
			// split the word by delimiter ',' and removing whitespaces 
			ArrayList aList= new ArrayList(Arrays.asList(restword.split("\\s*,\\s*")));
			 
			 
			// iterate the array and store <concept,keyword> pair into the multimap
			 for(int i=0;i<aList.size();i++)
			 {
				 rest = (String) aList.get(i);
				 ckMap.put(word, rest);

			 }
		}
		br.close();
		return ckMap;
		
		
	}


}
