LuceneTest ver1.0

***IMPORTANT NOTE***
--------------------

- Please make sure to clear indexDir before indexing
- Current java version will create a duplicate index entries if indexDir is not cleared


*** Instruction ***
-------------------

1. Copy this luceneTest folder under your htdocs direcotory


*** Indexing XML contents into Lucene ***

---------------------------------------

1. Run indexXML.php

P.S It's ok for your browser takes very long to process since it tooks about 50s to index all xml files 
    into lucene


*** Searching Keyword from Lucene ***
-----------------------------------


1. Run keywordSearch.php




*** Input / Output format ***
---------------------------


a. input format -
-----------------

1. Open keywordSearch.php
2. Edit $keyword value
2a. You can add operator 'AND' or '$$' for AND operation. e.g. 'Digital AND Signal AND Processing'` <- 1 keyword
2b. A space will serve as OR operation. e.g. 'Digital Signal Processing' = 'Digital || Signal || Processing'`	<3 keywords

b. output format - 
------------------

Line 1:	No. search results
Line 2->n: Search result string 

c. Search result string format -
--------------------------------

Document name, SegmentID, SpeakerID, SentenceID, Start time


d. Sample input and output
--------------------------

Input Keyword:
..............

news


Output:
.......

Found 5 hits.
1. AlaindeBotton_2009G,11,0,0,90.25
2. AlaindeBotton_2009G,8,0,0,76.85
3. AaronHuey_2010X,21,0,1,193.84
4. AlaindeBotton_2009G,68,0,11,376.31
5. AlanRussell_2006,98,0,0,579.51
 
~end