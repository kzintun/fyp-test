"""
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
 * @author Liu Xiao (c) 2015
 """

from __future__ import division
from stemming.porter2 import stem
import re
import operator

'''
        process results from text2onto
'''

'''store the concept results into a list'''
concept_text_path = "/Users/apple/Desktop/DearFYP/outDir_process/text2onto_normalized/4/Concept.txt"
#concept_text_path = "/Users/apple/Desktop/DearFYP/outDir_process/text2onto_sentence/6/Concept.txt"
concept_text_file = open(concept_text_path,'r')
concept_text = concept_text_file.read().split(', ')

'''rank the concept according to confidence number'''
concept_rank = {}
for index in range (len(concept_text)):
        concept_rank.setdefault(concept_text[index],'')
        concept_rank[concept_text[index]] = index

sorted_concept_rank_list = sorted(concept_rank.items(), key = operator.itemgetter(1))

'''store the list into a dictionary'''
sorted_concept_rank = {}
for item in sorted_concept_rank_list:
        sorted_concept_rank.setdefault(item[0],'')
        sorted_concept_rank[item[0]] = item[1]
print "Number of concepts Concept extracts: %d" %len(sorted_concept_rank)

stem_concept = []
for item in sorted_concept_rank:
        item = stem(item).title()
        if item not in stem_concept:
                stem_concept.append(item)
print "Number of stemmed concepts Concept extracts: %d" %len(stem_concept)


'''read subclassOf results from text2onto and store into a list'''
subclass_text_path = "/Users/apple/Desktop/DearFYP/outDir_process/text2onto_normalized/4/SubclassOf.txt"
#subclass_text_path = "/Users/apple/Desktop/DearFYP/outDir_process/text2onto_sentence/6/SubclassOf.txt"
subclass_text_file = open(subclass_text_path,'r')
subclass_text = subclass_text_file.read().split(', subclass-of')

'''store each subclass relation into a list'''
output = []
for subclass in subclass_text:
        subclass = subclass.replace("(","").replace(")","")
        splitSubclass = subclass.split(", ")
        output.append (splitSubclass)

'''store the subclassOf relation into a dictionary'''
subclass = []
superclass = []
subclassDict = {}
for item in output:
        if len(item) == 2:
                item[0] = item[0].strip() #subclass
                item[1] = item[1].strip() #superclass
                subclassDict.setdefault(stem(item[1]).title(),[])
                subclassDict[stem(item[1]).title()].append(stem(item[0]).title())
                
                if item[0].title() not in subclass:
                        subclass.append(item[0].title())  
                if item[1].title() not in superclass:
                        superclass.append(item[1].title())
print "Number of superclass Subclass-of extracts: %d" %len(superclass)
print "Number of subclass Subclass-of extracts: %d" %len(subclass)
print "Number of subclass-of relationships Subclass-of extracts: %d" %len(subclassDict)

'''find the subclass relations whose concept or subclass is in the concept result and store into a dictionary (treeNode)'''
processed_relation_dict = {}
for item in subclassDict:
        if (stem(item) in stem_concept):
                processed_relation_dict.setdefault(item,[])
                processed_relation_dict[item] = subclassDict[item]
        elif ((stem(subitem) for subitem in subclassDict[item]) in stem_concept):
                processed_relation_dict.setdefault(item,[])
                processed_relation_dict[item] = subclassDict[item]
        else:
                continue
print "Number of subclass-of relationships whose superclass or subclass are extracted as concepts (valid subclass-of relationship: %d" %len(processed_relation_dict)

'''sort the element according to index or confidence'''
sorted_treeNode_list = sorted(processed_relation_dict.items(), key = operator.itemgetter(1))

path = "/Users/apple/Desktop/dict1.txt"
with open (path, 'r') as infile:
        data = infile.read()

my_list_manual = data.splitlines()
conceptManual = []
for item in my_list_manual:
        if item not in conceptManual:
                conceptManual.append(item.strip().title())

manuallyConceptList = []
for item in conceptManual:
        if (item != ''):
                if item[0].isdigit():
                        matchObj = re.match(r'([0-9]+)((.[0-9]+)?(.[0-9]+)?(.[0-9]+)?)(\s)(.*)',item,re.M|re.I)
                        '''print matchObj.group(1)
                        print matchObj.group(2)
                        print matchObj.group(3)
                        print matchObj.group(4)
                        print matchObj.group(5)
                        #print matchObj.group(6) //space
                        print matchObj.group(7) '''
                        
                        manuallyConceptList.append(matchObj.group(7).title())

print "Number of concepts in manual concept tree: %d" %len(manuallyConceptList)

matchedConcept = []
for item in manuallyConceptList:
        if (stem(item).title()) in stem_concept:
                matchedConcept.append(item)
        elif (stem(item).title()) in processed_relation_dict.keys():
                matchedConcept.append(item)
        elif (stem(item).title()) in processed_relation_dict.values():
                matchedConcept.append(item)
print "Concepts in manual tree that are also extracted by Text2Onto: "
print matchedConcept
print "Number of mathed concepts: %d" %len(matchedConcept)

NumberOfValidConcepts = len(processed_relation_dict)
for item in processed_relation_dict:
        NumberOfValidConcepts += len(processed_relation_dict[item])
print "Number of valid concepts Text2Onto extracts: %d" %(NumberOfValidConcepts)

recall_Text2onto = len(matchedConcept) / len(manuallyConceptList)
precision_Text2onto = len(matchedConcept) / NumberOfValidConcepts
print "Recall Value (NO. of matched concepts / total NO. of concepts in manual tree): %f" %recall_Text2onto
print "Precision Value (No. of matched concepts / total NO. valid concepts extracted by Text2Onto): %f" %precision_Text2onto
