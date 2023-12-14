# Imports Blueprint Class and jsonify function
from flask import Blueprint, jsonify

#  Blueprint creation
home_bp = Blueprint('home',__name__)
#  Route Definition
@home_bp.route('/hello')
def hello():
    # Returns JSON response
    return jsonify({'aimodel':'openai',
                    'airesponse':'Ai Test Response Here'})