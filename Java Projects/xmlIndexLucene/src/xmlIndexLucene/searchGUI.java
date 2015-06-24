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
//	~~~~~~~~~~ SEARCH KEYWORD  ~~~~~~~~~~~~~~~~~~~~~ //
		
		//		 && or AND for 'and' operation
		//		 stopwords are excluded from searching
		//		 searching 'a b' will perform 'a' or 'b' operation
		
		/*			WILDCARD SEARCHES
		
		The single character wildcard search looks for terms that match that with the single character replaced. For example, to search for "text" or "test" you can use the search:
		te?t
		
		Multiple character wildcard searches looks for 0 or more characters. For example, to search for test, tests or tester, you can use the search:
		test*
		
		You can also use the wildcard searches in the middle of a term.
		te*t
		
		Note: You cannot use a * or ? symbol as the first character of a search.*/

package xmlIndexLucene;

import java.io.IOException;

import javax.xml.parsers.ParserConfigurationException;

import org.apache.lucene.queryparser.classic.ParseException;
import org.xml.sax.SAXException;

public class searchGUI {

	public static void main(String[] args) throws ParseException, IOException, ParserConfigurationException, SAXException {
		// TODO Auto-generated method stub
		
		//parseNsearch(args);
		
		String searchQ = "";
		String collName = ""; 
		
		//initialize instances for loading xml , storing to lucene and searching from lucene
		sendIndexToLucene sitl = new sendIndexToLucene();
		
	    // ** Uncommennt out to create JAR file **//
		
		/*
		if (args.length > 0){
			collName = args[args.length - 1]; 	// get collection name
	    	for (int s=0; s<args.length - 1; s++){
	    	searchQ += args[s] +" ";}		 	// get query string
	    	
	    	long startTime = System.nanoTime();
	    	sitl.readIndex(searchQ,collName);
	    	long endTime = System.nanoTime();
			System.out.println("Took "+(double)(endTime - startTime)/1000000000 + " second");
	    }
	    else
	    	searchQ = "Enter Keyword and collection ";
	    */
		
	    //testing
		
		searchQ = "frequency";
	    //collName = "signalprocessing";
		
	    //getting execution time
	    long startTime = System.nanoTime();
	    //code
		sitl.readIndex(searchQ,"tedtalk");	
		long endTime = System.nanoTime();
		System.out.println("Took "+(double)(endTime - startTime)/1000000000 + " second");
		
		
		long startTime1 = System.nanoTime();
		sitl.readIndex(searchQ,"signalprocessing");
		long endTime1 = System.nanoTime();
		System.out.println("Took "+(double)(endTime1 - startTime1)/1000000000 + " second");
		
		long startTime2 = System.nanoTime();
		sitl.readIndex(searchQ,"tedtalk");
		long endTime2 = System.nanoTime();
		System.out.println("Took "+(double)(endTime2 - startTime2)/1000000000 + " second"); 
		
	}
	
	public static void parseNsearch (String [] data) throws ParseException, IOException{
		
		String collName="";
		String searchQ="";
		sendIndexToLucene sitl = new sendIndexToLucene();
		
		/*
		if (data.length > 0){
			collName = data[data.length - 1]; 	// get collection name
	    	for (int s=0; s<data.length - 1; s++){
	    	searchQ += data[s] +" ";}		 	// get query string
	    	
	    	long startTime = System.nanoTime();
	    	sitl.readIndex(searchQ,collName);
	    	long endTime = System.nanoTime();
			System.out.println("Took "+(double)(endTime - startTime)/1000000000 + " second");
	    }
	    else
	    	searchQ = "Enter Keyword and collection ";
		*/
		
		searchQ = "frequency";
	    //collName = "signalprocessing";
		
	    //getting execution time
	    long startTime = System.nanoTime();
	    //code
		sitl.readIndex(searchQ,"tedtalk");	
		long endTime = System.nanoTime();
		System.out.println("Took "+(double)(endTime - startTime)/1000000000 + " second");
		
		
		long startTime1 = System.nanoTime();
		sitl.readIndex(searchQ,"signalprocessing");
		long endTime1 = System.nanoTime();
		System.out.println("Took "+(double)(endTime1 - startTime1)/1000000000 + " second");
		
		long startTime2 = System.nanoTime();
		sitl.readIndex(searchQ,"tedtalk");
		long endTime2 = System.nanoTime();
		System.out.println("Took "+(double)(endTime2 - startTime2)/1000000000 + " second");
		
		
	}
	
}
