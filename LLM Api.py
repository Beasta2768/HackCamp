from flask import jsonify,Flask,request,Blueprint
from openAi import llmCall
app = Flask(__name__)
llm = llmCall()


@app.route('/')
def airesponse():
    llmcall = llm.newprompt(request.args.get("prompt"))
    return jsonify({'response': llmcall})


app.run(debug=True)
