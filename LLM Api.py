from flask import jsonify,Flask,request,Blueprint
from openAi import llmCall

app = Flask(__name__)
llm = llmCall()

def test():
    return 'test'

@app.route('/')
def airesponse():
    llmcall = llm.newprompt(request.args.get("prompt"))
    return jsonify({'response': llmcall})

@app.route('/file')
def fileParse():
    llm.fileprocessor("TestLink")

app.run(debug=True)
