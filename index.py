from flask import jsonify,Flask,request,Blueprint
from home import home_bp

app = Flask(__name__)

app.register_blueprint(home_bp, url_prefix='/home')

if __name__ == '__main__':
    app.run(debug=True)
