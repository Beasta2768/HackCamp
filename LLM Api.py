# Imports - Imports necessary modules from Flask for creating the web application.
from flask import Flask, jsonify, flash, request, redirect, url_for, render_template, send_from_directory
from werkzeug.utils import secure_filename
import os
import openAi
from openAi import llmCall

# App Initialisation - Creates a Flask web application instance.
app = Flask(__name__)
llm = llmCall()

# Route for AI Response - Define a route / that returns a JSON response
# with a static 'response' key and the 'chat' parameter from the request.
@app.route('/')
def airesponse():
    try:
        if (request.args.get("file")):
            response = llm.fileprocessor(request.args.get("file"), request.args.get("prompt"))
            return response
        elif(request.args.get("prompt")):
            llmcall = llm.newprompt(request.args.get("prompt"))
            return jsonify({'response': llmcall, 'chat': request.args.get("chat")})
        else:
             return jsonify({'error': "No Prompt", 'message': "You Didn't Enter A prompt"})
    except Exception as ex:
        return jsonify({'error': type(ex).__name__, 'message': ex.args})

@app.route('/file')
def fileParse():
    if(request.args.get("file")):
            return jsonify({"file": request.args.get("file")})
    else:
        response = llm.fileprocessor("fileLink", "prompt")
        return response


# Run the App - Run the Flask application in debug mode if the script is executed directly.
if __name__ == '__main__':
    app.run(debug=True)
