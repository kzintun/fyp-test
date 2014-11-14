package xmlIndexLucene;

import java.io.File;
import java.io.IOException;

import org.apache.lucene.analysis.util.CharArraySet;
import org.apache.lucene.analysis.standard.StandardAnalyzer;
import org.apache.lucene.document.Document;
import org.apache.lucene.document.Field;
import org.apache.lucene.document.StringField;
import org.apache.lucene.document.TextField;
import org.apache.lucene.index.DirectoryReader;
import org.apache.lucene.index.IndexReader;
import org.apache.lucene.index.IndexWriter;
import org.apache.lucene.index.IndexWriterConfig;
import org.apache.lucene.queryparser.classic.ParseException;
import org.apache.lucene.queryparser.classic.QueryParser;
import org.apache.lucene.search.IndexSearcher;
import org.apache.lucene.search.Query;
import org.apache.lucene.search.ScoreDoc;
import org.apache.lucene.search.TopScoreDocCollector;
import org.apache.lucene.store.SimpleFSDirectory;
import org.apache.lucene.util.Version;

public class sendIndexToLucene {
	
 public void addToDoc(String id, String word, String colName) throws IOException, ParseException {
	  	
	 String newPath = "./indexDir/"+colName;
	 
	 File FILES_TO_INDEX_DIRECTORY1 = new File(newPath);
	 
	 if (!FILES_TO_INDEX_DIRECTORY1.exists()){
		 try{
			 FILES_TO_INDEX_DIRECTORY1.mkdir();
		     
			
		     } 
		 catch(SecurityException se){
		        System.out.println(se.getMessage());
		 }
	 }
	 	// here
	// 0. Specify the analyzer for tokenizing text.
	    //    The same analyzer should be used for indexing and searching
	   
		@SuppressWarnings("deprecation")
		//StandardAnalyzer analyzer = new StandardAnalyzer(Version.LUCENE_40);
	      StandardAnalyzer analyzer = new StandardAnalyzer(Version.LUCENE_4_10_0);

	    // 1. create the indexed
	    //FSDirectory index = new FSDirectory();
	    SimpleFSDirectory d = new SimpleFSDirectory(FILES_TO_INDEX_DIRECTORY1);
	    	
	    IndexWriterConfig config = new IndexWriterConfig(Version.LUCENE_4_10_0, analyzer);
	    IndexWriter w = new IndexWriter(d, config);
	    
	    // tokenized
	    Document doc = new Document();
	    
	    // indexing sentence
	    doc.add(new TextField("word", word, Field.Store.YES));
	    
	    // indexing collection name
	    doc.add(new StringField("collection", colName, Field.Store.YES));
	    
	    // indexing new attribute
	    //doc.add(new StringField("document", docName, Field.Store.YES));
	    
	    // use a string field for ids because we don't want it tokenized
	    doc.add(new StringField("ids", id, Field.Store.YES));
	    w.addDocument(doc);
	    w.close();
	 	
	    
  }
 
 public void readIndex(String querystr, String colName) throws ParseException, IOException{
		
	 String newPath= "./indexDir/" + colName;
	 //String testPath = "F://eclipse//workplace//xmlIndexLucene//indexDir//signalprocessing";
	 File FILES_TO_INDEX_DIRECTORY2 = new File(newPath);
	 
	 if (FILES_TO_INDEX_DIRECTORY2.exists() )
	 {
		 //System.out.println(newPath + " exists");
	 
	 	// 1. initialize
	 	@SuppressWarnings("deprecation")
		StandardAnalyzer analyzer = new StandardAnalyzer (Version.LATEST);
	 	
	 	// 1.a. without removing stopwords (not working!)
	 	//Analyzer analyzer1 = new StandardAnalyzer(Version.LUCENE_40, CharArraySet.EMPTY_SET); 
	 	
	 	SimpleFSDirectory ind = new SimpleFSDirectory(FILES_TO_INDEX_DIRECTORY2);
	 	
	 	// 2. query word
	    //String querystr = "photographs";
	    
	    
	    // the "word" arg specifies the default field to use
	    // when no field is explicitly specified in the query.
	    @SuppressWarnings("deprecation")
		Query q = new QueryParser(Version.LATEST, "word", analyzer).parse(querystr);
	  //  Query q1 = new QueryParser(Version.LATEST, "document", analyzer).parse(docName);
	   // Query q2 = new QueryParser(Version.LATEST, "collection", analyzer).parse(colName);
	    
	 // final query
	 //   BooleanQuery finalQuery = new BooleanQuery();
	  //  finalQuery.add(q, Occur.MUST); // MUST implies that the keyword must occur.
	   // finalQuery.add(q1, Occur.MUST); // Using all "MUST" occurs is equivalent to "AND" operator.
	    
	    // 3. search
	    int hitsPerPage = 150;
	    IndexReader reader = DirectoryReader.open(ind);
	    IndexSearcher searcher = new IndexSearcher(reader);
		TopScoreDocCollector collector = TopScoreDocCollector.create(hitsPerPage, true);
		searcher.search(q, collector);
		ScoreDoc[] hits = collector.topDocs().scoreDocs;
	
		// 4. display results
		System.out.println("Found " + hits.length + " hits." );
		
		
		/*System.out.println("\n\t\t----Search Results from Lucene---- \n"+ 
				"Document Name,SegmentID,SpeakerID,sentenceID,starttime	\t	Script\n"+
				"------------------------------------------------------	\t\t------\n");*/
		for(int i=0;i<hits.length;++i) {
		  int docId = hits[i].doc;
		  Document d = searcher.doc(docId);
		  
		  //	Display IDs
		  //System.out.println((i + 1) + ". " + d.get("ids").trim());
		  
		  // 	Display IDs and Sentence
		  //System.out.println((i + 1) + ". " + d.get("ids").trim() + ",\t\t" + d.get("word").trim());
		  
		  //	Display IDs, Collection name and Sentence
		  //System.out.println((i + 1) + ". " + d.get("ids").trim() + "\t\t" + d.get("collection").trim() + "\t\t"+d.get("word").trim());
		
		  //	Desired output for PHP front end
		  System.out.println(d.get("ids").trim() + ","+ d.get("word").trim());
		}
		
		
		
	    // reader can only be closed when there
	    // is no need to access the documents any more.
	    reader.close();
 	}
	 else
		 System.out.println("Can't locate index file. Enter correct collection name and path");
 }
 
  }

