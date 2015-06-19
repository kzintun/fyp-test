__author__ = 'Zin'


#!/usr/bin/python

import xml.etree.ElementTree as etree
import os.path



# ================================================================== #

def readXML(xmlFileName):

    if not os.path.exists(xmlFileName):
        print("\nError: The path to xml file OR The xml file does not exists! Exiting...")
        print("Use / instead of \ for path.")
        return -1

    elif os.path.exists(xmlFileName):
        tree = etree.parse(xmlFileName)
        root = tree.getroot()
        #print(root)
        return root


# ================================================================== #
# Get all the suggested words
def getSuggestList(xml):
    docList = list()

    for sug in xml.findall("suggestion"):
        #print(doc.attrib['name'])
        docList.append(sug.get('name'))
    return docList

# ================================================================== #
# Get the list of suggested words and collection pairs
def getCollectionList(xml):

    ttList = list()
    dspList = list()
    masterCollection = {}

    for sug in xml.findall("suggestion"):
        for col in sug.findall("collection"):
            if col.get('db') == 'tedtalk':
                #print('tedtalk')
                ttList.append(sug.get('name'))
            if col.get('db') == 'signalprocessing':
                #print('tedtalk')
                dspList.append(sug.get('name'))

        #print(doc.attrib['name'])
            #docList.append(col.get('db'))

    ttList.sort()
    dspList.sort()

    #Tuple data structure to hold all the lists of collection->keywords pair
    # Order of index is important : 0) tedTalk, 1) dsp
    masterTuple = ttList, dspList

    #Dictionary data structure to store the list of collection and keyword pairs

    masterCollection['tedtalk']= ttList
    masterCollection['signalprocessing'] = dspList
    #print('printing master Collection...\n')
    #print(masterCollection)

    return masterCollection

# ================================================================== #

def writeToTextFile(dictionary):

    # Write a line to the file
    for collectionName, keywordList in dictionary.items():

        # Filename to write
        dictfilename = collectionName + ".txt"
        dictfilename1 = "D:/" + collectionName + ".txt"

        # Open the file with writing permission
        myfile = open(dictfilename, 'w')

        print('Collection: ' + collectionName + ' --\tWordCount: ' + str(len(dictionary[collectionName])))
        for keyword in keywordList:
            #print(collectionName + '-' + keyword)
            myfile.write(keyword+'\n')

        # Close the file
        myfile.close()

    return 'done'

# ================================================================== #

suggestionXML1 = "C:/xampp/htdocs/lectssearch2015/suggestionDir/suggestions.xml"

suggestionXML = input("Enter the file name with path: ")

collection = readXML(suggestionXML)

if collection == -1:
    exit();

colList = getCollectionList(collection)

writeToTextFile(colList)







