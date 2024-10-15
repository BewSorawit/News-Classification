import os
import numpy as np
import tensorflow as tf
from transformers import TFDistilBertModel, DistilBertTokenizer
import pandas as pd
import matplotlib

import matplotlib.pyplot as plt
import seaborn as sns

import pickle

import re
import string
import nltk
from nltk.tokenize import word_tokenize, sent_tokenize
from nltk.corpus import stopwords
from nltk.stem import WordNetLemmatizer, PorterStemmer
nltk.download('stopwords',quiet=True)
nltk.download('punkt',quiet=True)
nltk.download('wordnet',quiet=True)
nltk.download('omw-1.4',quiet=True)
from sklearn import metrics
from sklearn.model_selection import train_test_split
from sklearn.metrics import f1_score, precision_score, recall_score
from sklearn.metrics import classification_report
from sklearn.metrics import confusion_matrix
from sklearn.preprocessing import  LabelEncoder
from sklearn.metrics.pairwise import cosine_similarity as cs

from wordcloud import WordCloud

import warnings

# ล้างหน่วยความจำ
tf.keras.backend.clear_session()

# ใช้ CPU แทน GPU
os.environ["CUDA_VISIBLE_DEVICES"] = "0"

# ใช้ eager execution
tf.config.run_functions_eagerly(True)

# โหลด tokenizer
tokenizer = DistilBertTokenizer.from_pretrained('distilbert-base-uncased')

# โหลดโมเดล
model_category_level_1 = tf.keras.models.load_model(
    'crud/model_category_level_1.h5',
    custom_objects={'TFDistilBertModel': TFDistilBertModel}
)



#clean
default_stemmer = PorterStemmer()
default_stopwords = stopwords.words('english')
default_stopwords = default_stopwords + ['said', 'would','even','according','could','year',
                                         'years','also','new','people','old,''one','two','time',
                                         'first','last','say','make','best','get','three','make',
                                         'year old','told','made','like','take','many','set','number',
                                         'month','week','well','back']
shortword = re.compile(r'\W*\b\w{1,4}\b\d')
BAD_SYMBOLS_RE = re.compile("[^a-zA-Z,\d]")
REPLACE_IP_ADDRESS = re.compile(r'\b(?:[0-9]{1,3}\.){3}[0-9]{1,3}\b')
REPLACE_BY_SPACE_RE = re.compile('[/(){}\[\]\|@,;]')
def clean_text(text, ):

    def tokenize_text(text):
        return [w for s in sent_tokenize(text) for w in word_tokenize(s) if len(w)>=3]

    def preprocessing_text(text):
        text = text.lower()
        text=text.replace('\n',' ').replace('\xa0',' ').replace('-',' ').replace('ó','o').replace('ğ','g').replace('á','a').replace("'"," ")
        text=re.sub(r'\d+','', text)
        text=re.sub(r'http\S+', '', text)
        text=BAD_SYMBOLS_RE.sub(' ', text)
        text=REPLACE_IP_ADDRESS.sub('', text)
        text=REPLACE_BY_SPACE_RE.sub(' ', text)
        text=' '.join(word for word in text.split() if len(word)>3)
        
        return text

    def remove_special_characters(text, characters=string.punctuation.replace('-', '')):
        tokens = tokenize_text(text)
        pattern = re.compile('[{}]'.format(re.escape(characters + '0123456789')))
        return ' '.join(filter(None, [pattern.sub('', t) for t in tokens]))

    def stem_text(text, stemmer=default_stemmer):
        tokens = tokenize_text(text)
        return ' '.join([stemmer.stem(t) for t in tokens])

    def lemm_text(text, lemm=WordNetLemmatizer()):
        tokens = tokenize_text(text)
        return ' '.join([lemm.lemmatize(t) for t in tokens])

    def remove_stopwords(text, stop_words=default_stopwords):
        tokens = [w for w in tokenize_text(text) if w not in stop_words]
        return ' '.join(tokens)
    
    text = text.strip(' ') # strip whitespaces
    text = text.lower() # lowercase
    #text = stem_text(text) # stemming
    text=preprocessing_text(text)
    text = remove_special_characters(text) # remove punctuation and symbols
    text = lemm_text(text) # lemmatizer
    text = remove_stopwords(text) # remove stopwords

    return text



maxlen = 80

# ฟังก์ชันเข้ารหัสข้อความใหม่
def regular_encode(texts, tokenizer, maxlen=80):
    tokens = tokenizer(texts, padding='max_length', truncation=True, max_length=maxlen, return_tensors='tf')
    return tokens['input_ids']

# เข้ารหัสข้อความใหม่

# X_new_encoded = regular_encode(dataClean, tokenizer, maxlen=maxlen)
# predictions_level_1 = model_category_level_1.predict(X_new_encoded)

# แสดงผลการทำนาย
# predicted_classes_level_1 = np.argmax(predictions_level_1, axis=1)

def select2Over85(predictions_level_1):
    max1=np.max(predictions_level_1)
    argmax1=np.argmax(predictions_level_1)
    predictions_level_1[argmax1] = 0
    max2=np.max(predictions_level_1)
    argmax2=np.argmax(predictions_level_1)
    if(max1>0.85 and max2>0.85):
        return [argmax1,argmax2]

    return [argmax1,5]
#                       0                                 1                       2                3                  4     5
cat =["arts, culture, entertainment and media","economy, business and finance","politics","science and technology","sport","-"]
def sendLabelFake(array):
    l1 = cat[array[0]]
    l2 = cat[array[1]]
    aws = [l1,l2]
    return aws

def predictByBjk(data):
    dataClean = clean_text(data)
    X_new_encoded = regular_encode(dataClean, tokenizer, maxlen=maxlen)
    pred = model_category_level_1.predict(X_new_encoded)
    getLabel = select2Over85(pred[0])
    getTextLabel = sendLabelFake(getLabel)
    return getTextLabel

# print(predictByBjk("The Biden administration sent a letter to the Israeli government demanding it act to improve the humanitarian situation in Gaza within the next 30 days or risk violating US laws governing foreign military assistance, suggesting US military aid could be in jeopardy. The Sunday letter, jointly written by US Secretary of State Antony Blinken and Secretary of Defense Lloyd Austin,  is addressed to Israeli Minister of Defense Yoav Gallant and Minister of Strategic Affairs Ron Dermer. It marks a significant new step by the US to try to compel Israel to facilitate the delivery of humanitarian aid into Gaza."))

