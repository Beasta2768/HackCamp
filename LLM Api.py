# Imports - Imports necessary modules from Flask for creating the web application.
from flask import Flask, jsonify, flash, request, redirect, url_for, render_template, send_from_directory
from werkzeug.utils import secure_filename
import os
import openAi
from openAi import llmCall

# App Initialisation - Creates a Flask web application instance.
app = Flask(__name__)
llm = llmCall()

# Configuration - Set configuration parameters such as the upload folder,
# allowed file extensions, and a secret key for Flask.
UPLOAD_FOLDER = "C:/Users/sgc544/OneDrive - University of Salford/upload"
# Set path to upload folder
ALLOWED_EXTENSIONS = {'txt', 'xlsx', 'svg'}
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER
app.config['SECRET_KEY'] = 'super_secret_key'


# Route for AI Response - Define a route / that returns a JSON response
# with a static 'response' key and the 'chat' parameter from the request.
@app.route('/')
def airesponse():
    try:
        # llmcall = llm.newprompt(request.args.get("prompt"))
        return jsonify({'response': "llmcall", 'chat': request.args.get("chat")})
    except Exception as ex:
        return jsonify({'error': type(ex).__name__, 'message': ex.args})


def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS


# File Upload Function - Define a route /upload that handles both GET and POST requests for file uploads.
@app.route('/upload', methods=['GET', 'POST'])
def upload_file():
    # File Upload Logic:
    # In the file upload route:
    # Check if the request method is POST and if the 'file' key is in the request.
    # Check if a file was selected and if it has an allowed file extension.
    # Save the file securely using secure_filename.
    # Flash a success message and redirect to the upload page.
    if request.method == 'POST':
        # Check if the post request has the file part
        if 'file' not in request.files:
            flash('No file part')
            return redirect(request.url)
        file = request.files['file']
        # If the user does not select a file, the browser submits an empty file without a filename.
        if file.filename == '':
            flash('No selected file')
            return redirect(request.url)
        if file and allowed_file(file.filename):
            # Securely save the file in the upload folder
            filename = secure_filename(file.filename)
            file.save(os.path.join(app.config['UPLOAD_FOLDER'], filename))
            flash('File uploaded successfully')
            return redirect(url_for('upload_file'))

    # Render Template for File Uploads - List the uploaded files and
    # render the upload.html template, passing the list of files to be displayed.
    files = os.listdir(app.config['UPLOAD_FOLDER'])
    return render_template('upload.html', files=files)


# Download File Route -  Define a route /uploads/<filename> for downloading files.
# It sends the file from the upload folder as an attachment.
@app.route('/uploads/<filename>')
def download_file(filename):
    return send_from_directory(app.config['UPLOAD_FOLDER'], filename, as_attachment=True)


# Run the App - Run the Flask application in debug mode if the script is executed directly.
if __name__ == '__main__':
    app.run(debug=True)
