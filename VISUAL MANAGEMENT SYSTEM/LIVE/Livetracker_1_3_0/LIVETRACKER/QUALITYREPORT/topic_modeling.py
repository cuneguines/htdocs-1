import sys
import json
import gensim
from gensim import corpora
import nltk
# Function to perform topic modeling
def perform_topic_modeling(text_data, num_topics=5):
    # Preprocess the text_data if necessary

    # Create a dictionary from the preprocessed text data
    dictionary = corpora.Dictionary(text_data)

    # Create a document-term matrix
    corpus = [dictionary.doc2bow(text) for text in text_data]

    # Perform LDA topic modeling
    lda_model = gensim.models.LdaModel(corpus=corpus, num_topics=num_topics, id2word=dictionary, passes=10)

    # Get the topics and their associated keywords
    topics = lda_model.print_topics(num_topics=num_topics)

    return topics

# Get the input from PHP
json_input =["Over 30 holes missing to attach legs to frame.","Blanking flanges from petrochem 8no rejected due to poor finish"]
tokens = nltk.word_tokenize(json_input)

# Create a dictionary and convert the tokenized words into a bag-of-words representation
dictionary = corpora.Dictionary([tokens])
bow = dictionary.doc2bow(tokens)

descriptions= json.dumps(json_input)
# Parse the JSON input


# Perform topic modeling on the descriptions
topics = perform_topic_modeling(descriptions, num_topics=5)

