import processText
import operator
import pyPdf

stoppath = "/Users/apple/desktop/DearFYP/processText/SmartStoplist.txt"

processText_object = processText.Rake(stoppath)

#sample_file = open("/Users/apple/desktop/DearFYP/processText/data/docs/pdf/lecture2.pdf",'r')
#sample_file = open("/Users/apple/desktop/DearFYP/processText/data/docs/pdf0/lecture26.txt","r")
sample_file = open("/Users/apple/desktop/DearFYP/processText/data/docs/pdf1/lec15.txt","r")
text = sample_file.read()
 
'''split text into sentences
'''
sentenceList = processText.split_sentences(text)
                   
for sentence in sentenceList:
	print "Sentence:", sentence.strip()
                   
''' generate candidate keywords
'''
stopwordpattern = processText.build_stop_word_regex(stoppath)
phraseList = processText.generate_candidate_keywords(sentenceList, stopwordpattern,1,5)
print "Phrases:", phraseList

''' calculate individual word scores
'''
wordscores = processText.calculate_word_scores(phraseList)

'''calculate phrase scores
'''
phrasescores = processText.calculate_phrase_scores(phraseList)

''' generate candidate keyword scores
'''
keywordcandidates = processText.generate_candidate_keyword_scores(phraseList,wordscores,phrasescores)
for candidate in keywordcandidates.keys():
	print "Candidate:", candidate, ", score: ", keywordcandidates.get(candidate)

''' sort candidate by score
'''
sortedKeywords = sorted(keywordcandidates.iteritems(),key=operator.itemgetter(1),reverse=True)
totalKeywords=len(sortedKeywords)

'''for keyword in sortedKeywords[0:(totalKeywords/3)]:
   print "Keyword:", keyword[0],", score: ", keyword[1]
'''
for keyword in sortedKeywords:
    if keyword[1] >= 0.4:
        print "Keyword:", keyword[0],", score: ", keyword[1]
                   

