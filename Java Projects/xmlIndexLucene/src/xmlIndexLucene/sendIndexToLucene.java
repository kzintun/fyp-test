package xmlIndexLucene;

import java.io.File;
import java.io.IOException;
import java.util.Arrays;
import java.util.HashMap;
import java.util.Map;

import org.apache.lucene.analysis.util.CharArraySet;
import org.apache.lucene.analysis.en.EnglishAnalyzer;
import org.apache.lucene.analysis.standard.StandardAnalyzer;
import org.apache.lucene.document.Document;
import org.apache.lucene.document.Field;
import org.apache.lucene.document.StringField;
import org.apache.lucene.document.TextField;
import org.apache.lucene.index.CorruptIndexException;
import org.apache.lucene.index.DirectoryReader;
import org.apache.lucene.index.IndexReader;
import org.apache.lucene.index.IndexWriter;
import org.apache.lucene.index.IndexWriterConfig;
import org.apache.lucene.index.Term;
import org.apache.lucene.queryparser.classic.ParseException;
import org.apache.lucene.queryparser.classic.QueryParser;
import org.apache.lucene.search.IndexSearcher;
import org.apache.lucene.search.spell.Dictionary;
import org.apache.lucene.search.spell.SpellChecker;
import org.apache.lucene.search.spell.LuceneDictionary;
import org.apache.lucene.search.PhraseQuery;
import org.apache.lucene.search.Query;
import org.apache.lucene.search.ScoreDoc;
import org.apache.lucene.search.TopDocs;
import org.apache.lucene.search.TopScoreDocCollector;
import org.apache.lucene.store.SimpleFSDirectory;
import org.apache.lucene.util.Version;
import org.apache.lucene.store.Directory;


public class sendIndexToLucene {
	
 private static final org.apache.lucene.analysis.util.CharArraySet CharArraySet = null;

// Index input stream - STOPWORDS // obsolete now // Use addToDoc1 for faster indexing
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

// Index input stream + STOPWORDS
 public void addToDoc1(Map indexData, String colName) throws IOException, ParseException {
	  	
	 String newPath = "./indexDir/"+colName;
	 String id,word;
	 Map<String, String> newIndexData = new HashMap<String, String>();
	 newIndexData = indexData;
	 
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
		
		// **Use the analyzer below to remove stopwords from transcript
	    // StandardAnalyzer analyzer = new StandardAnalyzer(Version.LUCENE_4_10_0);
		
		// **use the analyzer below to ignore stopwords from transcript (stopwords are required for phrase search)
		StandardAnalyzer analyzer = new StandardAnalyzer(org.apache.lucene.analysis.util.CharArraySet.EMPTY_SET);
		//EnglishAnalyzer analyzer = new EnglishAnalyzer();
		
	    // 1. create the indexed
	    //FSDirectory index = new FSDirectory();
	    SimpleFSDirectory d = new SimpleFSDirectory(FILES_TO_INDEX_DIRECTORY1);
	    	
	    IndexWriterConfig config = new IndexWriterConfig(Version.LUCENE_4_10_0, analyzer);
	    IndexWriter w = new IndexWriter(d, config);
	    
	    // extract each sentence from hashmap and index
	    for (Map.Entry<String, String> entry : newIndexData.entrySet())
		{
			  
			id = entry.getKey();
			word = entry.getValue();
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
		}
	    w.close();
	 	
	    
  }
 
 // *************** Keyword Search ********************
 public void readIndex(String querystr, String colName) throws ParseException, IOException{
		
	 String newPath= "./indexDir/" + colName;
	 //String testPath = "F://eclipse//workplace//xmlIndexLucene//indexDir//signalprocessing";
	 File FILES_TO_INDEX_DIRECTORY2 = new File(newPath);
	 
	 if (FILES_TO_INDEX_DIRECTORY2.exists() )
	 {
		 //System.out.println(newPath + " exists");
	 
	 	// 1. initialize
		// Analyzer that remove stop words 
	 	@SuppressWarnings("deprecation")
		StandardAnalyzer analyzer = new StandardAnalyzer (Version.LATEST);
	 	//StandardAnalyzer analyzer = new StandardAnalyzer(org.apache.lucene.analysis.util.CharArraySet.EMPTY_SET);
	 	//EnglishAnalyzer analyzer = new EnglishAnalyzer();
	 	
	 	// 1.a. without removing stopwords (not working!)
	 	//Analyzer analyzer1 = new StandardAnalyzer(Version.LUCENE_40, CharArraySet.EMPTY_SET); 
	 	
	 	SimpleFSDirectory ind = new SimpleFSDirectory(FILES_TO_INDEX_DIRECTORY2);
	 	
	 	// 2. query word
	    //String querystr = "photographs";
  
	    // the "word" arg specifies the default field to use
	    // when no field is explicitly specified in the query.
	   // @SuppressWarnings("deprecation")
		//Query q = new QueryParser(Version.LATEST, "word", analyzer).parse(querystr);
	  //  Query q1 = new QueryParser(Version.LATEST, "document", analyzer).parse(docName);
	   // Query q2 = new QueryParser(Version.LATEST, "collection", analyzer).parse(colName);
	    
	    // 3. search
	 	// The most computationally expensive part of searching is score calculation.
	 	// It may take several seconds for large result sets (tens of thousands of hits).
	    int hitsPerPage = 150;
	    IndexReader reader = DirectoryReader.open(ind);
	    IndexSearcher searcher = new IndexSearcher(reader);
		TopScoreDocCollector collector = TopScoreDocCollector.create(hitsPerPage, true);
		@SuppressWarnings("deprecation")
		Query q = new QueryParser(Version.LATEST, "word", analyzer).parse(querystr);
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
 
 
 // ***************** Phrase search ***********************
 public void readIndex1(String querystr, String colName) throws IOException, ParseException{
		
	 String newPath= "./indexDir/" + colName;
	 
	 File FILES_TO_INDEX_DIRECTORY2 = new File(newPath);
	 
	 if (FILES_TO_INDEX_DIRECTORY2.exists() )
	 {
		 //System.out.println(newPath + " exists");
	 
	 	// 1. initialize
	 	@SuppressWarnings("deprecation")
		//StandardAnalyzer analyzer = new StandardAnalyzer (Version.LATEST);
	 	//StandardAnalyzer analyzer = new StandardAnalyzer(org.apache.lucene.analysis.util.CharArraySet.EMPTY_SET);

	 	
	 	// 1.a. without removing stopwords (not working!)
	 	//Analyzer analyzer1 = new StandardAnalyzer(Version.LUCENE_40, CharArraySet.EMPTY_SET); 
	 	
	 	SimpleFSDirectory ind = new SimpleFSDirectory(FILES_TO_INDEX_DIRECTORY2);
	 	
	 	// 2. query word
	    //String querystr = "photographs";
	 	 PhraseQuery query = new PhraseQuery();
	        String[] words = querystr.split(" ");
	        for (String word : words) {
	            query.add(new Term("word", word));
	        }
	        
	    // the "word" arg specifies the default field to use
	    // when no field is explicitly specified in the query.
	    @SuppressWarnings("deprecation")
		//Query q = new QueryParser(Version.LATEST, "word", analyzer).parse(querystr);
	  //  Query q1 = new QueryParser(Version.LATEST, "document", analyzer).parse(docName);
	   // Query q2 = new QueryParser(Version.LATEST, "collection", analyzer).parse(colName);
	    
	 // final query
	 //   BooleanQuery finalQuery = new BooleanQuery();
	  //  finalQuery.add(q, Occur.MUST); // MUST implies that the keyword must occur.
	   // finalQuery.add(q1, Occur.MUST); // Using all "MUST" occurs is equivalent to "AND" operator.
	    
	    // 3. search
	   // int hitsPerPage = 150;
	    IndexReader reader = DirectoryReader.open(ind);
	    IndexSearcher searcher = new IndexSearcher(reader);
	    
		//TopScoreDocCollector collector = TopScoreDocCollector.create(hitsPerPage, true);
		//searcher.search(q, collector);
		//ScoreDoc[] hits = collector.topDocs().scoreDocs;
		
		TopDocs topDocs = searcher.search(query, 150);
		System.out.println("Found " + topDocs.totalHits + " hits." );
        for (ScoreDoc scoreDoc : topDocs.scoreDocs) {
            Document doc = searcher.doc(scoreDoc.doc);
            System.out.println(doc.get("ids").trim() + ","+ doc.get("word").trim());
        }
		
						
	    // reader can only be closed when there
	    // is no need to access the documents any more.
	    reader.close();
 	}
	 else
		 System.out.println("Can't locate index file. Enter correct collection name and path");
 }
 
 public void createSpellChekerIndex() throws CorruptIndexException, IOException {
	 
	 String newPath= "./indexDir/signalprocessing";
	 //Directory spellDir = new Directory();
	 
	 File FILES_FROM_INDEX_DIRECTORY = new File(newPath);
	 if (FILES_FROM_INDEX_DIRECTORY.exists() )
	 {
		 SimpleFSDirectory sfsdir = new SimpleFSDirectory(FILES_FROM_INDEX_DIRECTORY);
		 //final IndexReader reader = IndexReader.open(newPath, true);
		 final IndexReader reader = DirectoryReader.open(sfsdir);
		 final Dictionary dictionary = new LuceneDictionary(reader,"word");
		 
		 final SpellChecker spellChecker = new SpellChecker(sfsdir);
		 final StandardAnalyzer analyzer = new StandardAnalyzer();
		 final IndexWriterConfig writerConfig = new IndexWriterConfig(Version.LUCENE_36, analyzer);
		 
		 spellChecker.indexDictionary(dictionary, writerConfig, true);
		 
		 //SpellChecker spell= new SpellChecker(dictionaryDirectory);
		// spellChecker.indexDictionary(new LuceneDictionary(my_luceneReader,my_fieldname));
		 String[] suggestions = spellChecker.suggestSimilar("signall", 1);
		 System.out.println(Arrays.toString(suggestions));
		 spellChecker.close();
	 }
	 
 }
 
 
 
 
  }

