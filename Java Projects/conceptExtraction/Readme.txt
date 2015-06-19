Input
_____

Concept annotation file:
./conceptDir/DSPmatching.txt

Transcript files:
./xmlDir/signalprocessing/


Output
______

./conceptDir/signalprocessing.xml



Instruction
___________

1. Run loadConceptfrmXML.java


Sequence of class calls
-----------------------

loadConceptfrmXML -> conceptTextToMap --> extConceptfrmXML --> writeConceptToXML



1. loadConceptfrmXML - Main/Controller class that initializes all other classes and perform the whole operation
2. conceptTextToMap  - Read from concept annotation text file and  populate pairs into MultiMap
3. extConceptfrmXML  - Read each transcript and check if terms is found in each sentence, populate MultiMap of sentences metadata and concept
3. writeConceptToXML - Retrieve <concept,metada> and write them out to XML which will be used for concept-search in Lectssearch  



