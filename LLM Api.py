# Imports - Imports necessary modules from Flask for creating the web application.
from flask import Flask, jsonify, request, render_template , send_file
from flask_uploads import UploadSet, configure_uploads
from openAi import llmCall

# App Initialisation - Creates a Flask web application instance.
app = Flask(__name__)
llm = llmCall()

files = UploadSet('files', extensions=('txt', 'pdf', 'doc', 'docx', 'csv'))
app.config['UPLOADED_FILES_DEST'] = 'uploads'
configure_uploads(app, files)

# Route for AI Response - Define a route / that returns a JSON response
# with a static 'response' key and the 'chat' parameter from the request.
@app.route('/')
def airesponse():
    try:
        if (request.args.get("file")):
            response = llm.fileprocessor(request.args.get("file"), request.args.get("prompt"))
            print(response)
            return jsonify({"response": response})
        elif(request.args.get("prompt")):
            llmcall = llm.newprompt(request.args.get("prompt"))
            return jsonify({'response': llmcall, 'chat': request.args.get("chat")})
        else:
             return jsonify({'error': "No Prompt", 'message': "You Didn't Enter A prompt"})
    except Exception as ex:
        return jsonify({'error': type(ex).__name__, 'message': ex.args})


@app.route('/upload', methods=['POST'])
def upload():
    fileDecoded = request.files.get("data_file").stream.read().decode()
    dataFile = open("uploads/dataFile.csv", "w")
    dataFile.write(fileDecoded.replace("\n", '', ))
    dataFile.close()
    # filename = files.save(request.files.get('data_file'))
    # file_url = files.url(filename)
    # print(f'Successfully uploaded the file {filename} : <a href="{file_url}">{file_url}</a>')
    # return f'Successfully uploaded the file {filename} : <a href="{file_url}">{file_url}</a>'
    # response = llm.fileprocessor(request.files.get('data_file'), request.args.get("prompt"))
    uploaded_file = request.files['data_file']
    try:
        if uploaded_file != '':
            response = llm.fileprocessor("uploads/dataFile.csv", request.args.get("prompt"))
            print(response)
            return jsonify({"response": response})
            # return jsonify({'error': "Feature Unavailable", 'message': "Testing In Progress"})
        else:
            return jsonify({'error': "Server Upload Error", 'message': 'Upload failed, no file was included in the POST request'})
    except Exception as ex:
        return jsonify({'error': type(ex).__name__, 'message': ex.args})

@app.route("/files")
def files():
    return send_file("uploads/dataFile.csv")

# Run the App - Run the Flask application in debug mode if the script is executed directly.
if __name__ == '__main__':
    app.run(debug=True)
