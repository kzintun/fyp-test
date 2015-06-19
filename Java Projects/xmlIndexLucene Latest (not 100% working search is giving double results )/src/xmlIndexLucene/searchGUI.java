package xmlIndexLucene;

import java.io.IOException;

import javax.xml.parsers.ParserConfigurationException;

import org.apache.lucene.queryparser.classic.ParseException;
import org.xml.sax.SAXException;

public class searchGUI {

	public static void main(String[] args) throws ParseException, IOException, ParserConfigurationException, SAXException {
		// TODO Auto-generated method stub
		String searchQ = "";
		String collName = ""; 
				
		//initialize instances for loading xml , storing to lucene and searching from lucene
		sendIndexToLucene sitl = new sendIndexToLucene();
		
		 //	~~~~~~~~~~ENTER SEARCH KEYWORD HERE ~~~~~~~~~~~~~~~~~~~~~
		
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
	    
		if (args.length > 0){
			collName = args[args.length - 1];
	    	for (int s=0; s<args.length - 1; s++){
	    	searchQ += args[s] +" ";}
	    	
	    	sitl.readIndex(searchQ,collName);
	    }
	    else
	    	searchQ = "Enter Keyword and collection ";
	    
		
		
	    //testing
		//searchQ = "what AND is";
	    //collName = "aerospace";
		
	   // System.out.println(searchQ +" "+ collName);
	    
		sitl.readIndex(searchQ,collName);
	}

}
