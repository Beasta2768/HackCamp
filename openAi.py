import dotenv
from dotenv import load_dotenv
from langchain.chat_models import ChatOpenAI
from langchain.schema import HumanMessage, SystemMessage,AIMessage
from flask import jsonify,Flask,request,Blueprint


app = Flask(__name__)

load_dotenv("llm.env")



@app.route('/')
def aiResponse():
    chat = ChatOpenAI()
    conversation = chat(
        [
            HumanMessage(
                content="What is the capital of Ghana"
            ),
            AIMessage(content="J'adore la programmation.", additional_kwargs={}, example=False)
        ]
    )
    return jsonify({'response':conversation.content})

app.run(debug=True)