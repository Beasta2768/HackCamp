import dotenv
from dotenv import load_dotenv
from langchain.chat_models import ChatOpenAI
from langchain.schema import HumanMessage, SystemMessage,AIMessage
from flask import jsonify,Flask,request,Blueprint


app = Flask(__name__)

dotenv.load_dotenv("llm.env")



@app.route('/')
def airesponse():
    chat = ChatOpenAI()
    conversation = chat(
        [
            HumanMessage(
                content=request.args.get('prompt')
            ),
            AIMessage(content="J'adore la programmation.", additional_kwargs={}, example=False)
        ]
    )
    print(request.args.get('prompt'))
    return jsonify({'response': conversation.content})


app.run(debug=True)



