from flask import Blueprint, jsonify

home_bp = Blueprint('home',__name__)
@home_bp.route('/hello')
def hello():
    return jsonify({'aimodel':'openai',
                    'airesponse':'Ai Test Response Here'})

