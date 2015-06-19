package xmlIndexLucene;

import java.io.IOException;

import javax.xml.parsers.ParserConfigurationException;

import org.apache.lucene.queryparser.classic.ParseException;
import org.xml.sax.SAXException;

public class searchGUI {

	public static void main(String[] args) throws ParseException, IOException, ParserConfigurationException, SAXException {
		// TODO Auto-generated method stub
		
		//initialize instances for loading xml , storing to lucene and searching from lucene
		sendIndexToLucene sitl = new sendIndexToLucene();
		loadAllXML lax = new loadAllXML();
		
		
		// 		Start Here
		// 	~~~~~~~~~~~~ Load XML from the directory (F:/eclipse/Workplace/xmlIndexLucene/xmlDir) and index the contents into lucene
		//  	Uncomment the following line to load XML content into LUCENE
		//lax.loadAllXML();
		
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
	    
		String searchQ = "lakota";
	    sitl.readIndex(searchQ);
	    
		
	}

}
