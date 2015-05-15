import re
import operator

debug = False
test = False
"""
    check whether the parameter is a number
"""
def is_number(s):
    try:
        float(s) if '.' in s else int(s)
        return True
    except ValueError:
        return False

"""
    load stop words from a file and return as a list of words
    @param stop_word_file: Path and file name of a file containing stop words
    @return a list of stop words
"""
def load_stop_words(stop_word_file):
    stop_words = []
    for line in open(stop_word_file):
        if line.strip()[0:1] != "#":
            for word in line.split():  # in case more than one per line
                stop_words.append(word)
    return stop_words

"""
    return a list of all words that are have a length greater than a specified number of characters
    @param text: The text that need be split in to words
    @param min_word_return_size: The minimum no of characters a word must have to be included
"""
def separate_words(text, min_word_return_size):
    splitter = re.compile('[^a-zA-Z0-9_\\+\\-/]')
    words = []
    for single_word in splitter.split(text):
        current_word = single_word.strip().lower()
        if len(current_word) > min_word_return_size and current_word != '' and not is_number(current_word):
            words.append(current_word)
    return words

"""
    return a list of sentences
    @param text: The text that need be split in to sentences
"""
def split_sentences(text):
    sentence_delimiters = re.compile(u'[\\[\\]\n.!?,;:\t\\"\\(\\)\u2019\u2013]')
    sentences = sentence_delimiters.split(text)
    return sentences

'''
    return a stop word pattern using regular expression
    @param stop_word_file_path: The file path of the stop word list
'''
def build_stop_word_regex(stop_word_file_path):
    stop_word_list = load_stop_words(stop_word_file_path)
    stop_word_regex_list = []
    for word in stop_word_list:
        word_regex = '\\b' + word + '\\b'
        stop_word_regex_list.append(word_regex)
    stop_word_pattern = re.compile('|'.join(stop_word_regex_list), re.IGNORECASE)
    return stop_word_pattern

def generate_phrases(sentence_list, stopword_pattern):
    sentence_phrase_list = []
    tem_sentence_list = []

    for sentence in sentence_list:
        tem_sentence = sentence.replace("-","_")
        tem_sentence_list.append(tem_sentence)

    for s in tem_sentence_list:
        tmp = re.sub(stopword_pattern, '|', s.strip())
        phrases = tmp.replace(" |",'').replace("|",'')
        sentence_phrase_list.append(phrases)
    return sentence_phrase_list


'''
    retrun a list of phrases that are left from removing stop words in sentences
    @param sentence_list: List of sentences that need be removed stop words
    @param stopword_pattern: Step word pattern got from build_stop_word_regex
    @min_char_length: Minimum length of characters in a phrase
    @max_words_lenth: Maximum number of words in a phrase
'''
def generate_candidate_keywords(sentence_list, stopword_pattern, min_char_length=1, max_words_length=3):
    phrase_list = []   
    tem_sentence_list = []

    for sentence in sentence_list:
    	tem_sentence = sentence.replace("-","_")
    	tem_sentence_list.append(tem_sentence)
    	
    for s in tem_sentence_list:
        tmp = re.sub(stopword_pattern, '|', s.strip())
        phrases = tmp.split("|")
        for phrase in phrases:
            phrase = phrase.strip().lower()
            if phrase != "" and is_acceptable(phrase, min_char_length, max_words_length):
            	phrase = phrase.replace("_","-")
                phrase_list.append(phrase)
                
    return phrase_list


def is_acceptable(phrase, min_char_length, max_words_length):

    # a phrase must have a min length in characters
    if len(phrase) < min_char_length:
        return 0

    # a phrase must have a max number of words
    words = phrase.split()
    if len(words) > max_words_length:
        return 0

    digits = 0
    alpha = 0
    for i in range(0, len(phrase)):
        if phrase[i].isdigit():
            digits += 1
        elif phrase[i].isalpha():
            alpha += 1

    # a phrase must have at least one alpha character
    if alpha == 0:
        return 0

    # a phrase must have more alpha than digits characters
    if digits > alpha:
        return 0
    return 1




'''def calculate_word_scores(phraseList):
    word_frequency = {}
    word_degree = {}
    for phrase in phraseList:
        word_list = separate_words(phrase, 0) #['digital', 'signal', 'processing','digital']
        word_list_length = len(word_list)
        #word_list_degree = word_list_length - 1
        #if word_list_degree > 3: word_list_degree = 3 #exp.
        for word in word_list:
            word_frequency.setdefault(word, 0)
            word_frequency[word] += 1 #word_frequency: {'signal':1, 'processing':1,'digital':2}
            #word_degree.setdefault(word, 0)
            #word_degree[word] += word_list_degree    #word_degree: {'signal':3, 'processing':3,'digital':6}
            #word_degree[word] += 1/(word_list_length*1.0) #exp.
    #for item in word_frequency:
        #word_degree[item] = word_degree[item] + word_frequency[item] 
    phrase_frequency = {}
    for phrase in phraseList:
    	phrase_frequency.setdefault(phrase,0)
    for phrase in phraseList:
		for index in range (len(phraseList)):
			if phrase in phraseList[index]:
				phrase_frequency[phrase] += 1
		
    # Calculate Word scores = deg(w)/frew(w)
    word_score = {}
    for item in word_frequency:
        word_score.setdefault(item, 0)
        #word_score[item] = word_degree[item] / (word_frequency[item] * 1.0)  #orig.  ((len of phrase-1)*word_freqeuncy+word_frequency)/word_frequency
        word_score[item] = word_frequency[item] * 1.0
        #word_score[item] = word_frequency[item]/(word_degree[item] * 1.0) #exp.
    for item in phrase_frequency:
    	word_score.setdefault(item,0)
    	word_score[item] = phrase_frequency[item] * 1.0
    return word_score
	# if a word occurs only once, score = length of the phrase the word in
	# if a word occurs more than once, score = (sum of the length of the phrases the word is in)/frequency'''
	
def calculate_word_scores(phraseList):
	word_frequency = {}
	for phrase in phraseList:
		word_list = separate_words(phrase,0)
		for word in word_list:
			word_frequency.setdefault(word,0)
			word_frequency[word] += 1
	word_score = {}
	for item in word_frequency:
		word_score.setdefault(item,0)
		word_score[item] = word_frequency[item] * 1.0
	return word_score

def calculate_word_position(phraseList):
    word_position = {}
    for phrase in phraseList:
        word_list = separate_words(phrase,0)
        for index in range(len(word_list)):
            word_position.setdefault(word_list[index],index)
            word_position[word_list[index]] += index
    return word_position

def calculate_phrase_scores(phraseList):
	phrase_frequency = {}
	for phrase in phraseList:
		phrase_frequency.setdefault(phrase,0)
		for index in range (len(phraseList)):
			if phrase in phraseList[index]:
				phrase_frequency[phrase] += 1
	phrase_score = {}
	for item in phrase_frequency:
		phrase_score.setdefault(item,0)
		phrase_score[item] = phrase_frequency[item] * 1.0
	return phrase_score
	
def generate_candidate_keyword_scores(phrase_list, word_score, phrase_score, min_keyword_frequency=1):
    keyword_candidates = {}

    for phrase in phrase_list:   
        if min_keyword_frequency > 1:
            if phrase_list.count(phrase) < min_keyword_frequency:
                continue
        keyword_candidates.setdefault(phrase, 0) 
        word_list = separate_words(phrase, 0) 
        candidate_score = phrase_score[phrase]
        for word in word_list:
            candidate_score +=  word_score[word] 
        keyword_candidates[phrase] = candidate_score
        
    #normalize the candidate keyword scores
    score_list = []
    for phrase in phrase_list:
    	score_list.append(keyword_candidates[phrase])
    max_score = max(score_list)
    min_score = min(score_list)
    for phrase in keyword_candidates.keys():
    	keyword_candidates[phrase] = round((((keyword_candidates[phrase] - min_score)/(max_score - min_score)) * (10-0)),1)
    return keyword_candidates

'''def construct_keyword_hierarchy(keyword_candidates):
	sorted_keywords = sorted(keyword_candidates.iteritems(),key=operator.itemgetter(1),reverse=True)
	candidates = []
	for index in range (len(sorted_keywords)):
		candidates.append(sorted_keywords[index][0])
	
	#phrase_length = {}
	hierarchy_rank = {}
	word_list = {}
	is_supclass = {}
	ranking = 1
	sub_rank = 0.1
	for index in range(len(candidates),0,-1):
		word_list.setdefault(index,'')
		word_list[index] = separate_words(candidates[index-1],0)
	for index in range(len(candidates),0,-1):
		for count in range(len(word_list[index])):
			hierarchy_rank.setdefault(word_list[index][count],0)
			hierarchy_rank.setdefault(candidates[index-1],0)
			is_supclass.setdefault(word_list[index][count],False)
	for index in range(len(candidates),0,-1):
                                for count in range(len(word_list[index])):
                                    for checking in range(index-1):
                                        if(word_list[index][count] in word_list[checking+1]):
                                            is_supclass[word_list[index][count]] = True
                                            hierarchy_rank[word_list[index][count]] = ranking
                                            hierarchy_rank[candidates[index-1]] = ranking + sub_rank
                                            sub_rank += 0.1
                                    if (is_supclass[word_list[index][count]] == True):
                                        ranking += 1
                                        sub_rank = 0.1
	return hierarchy_rank'''
				

class Rake(object):
    def __init__(self, stop_words_path, min_char_length=1, max_words_length=5, min_keyword_frequency=1):
        self.__stop_words_path = stop_words_path
        self.__stop_words_pattern = build_stop_word_regex(stop_words_path)
        self.__min_char_length = min_char_length
        self.__max_words_length = max_words_length
        self.__min_keyword_frequency = min_keyword_frequency

    def run(self, text):
        sentence_list = split_sentences(text)

        phrase_list = generate_candidate_keywords(sentence_list, self.__stop_words_pattern, self.__min_char_length, self.__max_words_length)

        word_scores = calculate_word_scores(phrase_list)

        keyword_candidates = generate_candidate_keyword_scores(phrase_list, word_scores, self.__min_keyword_frequency)

        sorted_keywords = sorted(keyword_candidates.iteritems(), key=operator.itemgetter(1), reverse=True)
        return sorted_keywords


if test:
    text = "Compatibility of systems of linear constraints over the set of natural numbers. Criteria of compatibility of a system of linear Diophantine equations, strict inequations, and nonstrict inequations are considered. Upper bounds for components of a minimal set of solutions and algorithms of construction of minimal generating sets of solutions for all types of systems are given. These criteria and the corresponding algorithms for constructing a minimal supporting set of solutions can be used in solving all the considered types of systems and systems of mixed types."

    # Split text into sentences
    sentenceList = split_sentences(text)
    #stoppath = "FoxStoplist.txt" #Fox stoplist contains "numbers", so it will not find "natural numbers" like in Table 1.1
    stoppath = "RAKE/SmartStoplist.txt"  #SMART stoplist misses some of the lower-scoring keywords in Figure 1.5, which means that the top 1/3 cuts off one of the 4.0 score words in Table 1.1
    stopwordpattern = build_stop_word_regex(stoppath)

    # generate candidate keywords
    phraseList = generate_candidate_keywords(sentenceList, stopwordpattern)

    # calculate individual word scores
    wordscores = calculate_word_scores(phraseList)

    # generate candidate keyword scores
    keywordcandidates = generate_candidate_keyword_scores(phraseList, wordscores)
    if debug: print keywordcandidates

    sortedKeywords = sorted(keywordcandidates.iteritems(), key=operator.itemgetter(1), reverse=True)
    if debug: print sortedKeywords

    totalKeywords = len(sortedKeywords)
    if debug: print totalKeywords
    print sortedKeywords[0:(totalKeywords / 3)]

    rake = Rake("SmartStoplist.txt")
    keywords = rake.run(text)
    print keywords
