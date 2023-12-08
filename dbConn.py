import mysql.connector

mydb= mysql.connector.connect(
    host='poseidon.salford.ac.uk',
    user='hc23-16',
    password='rEjEBVlTJeO606X',
    port=3306,
    database='hc23_16'
)

# To query and work with result in python

mycursor = mydb.cursor()

mycursor.execute('SELECT * FROM conversations')

conversations = mycursor.fetchall()

for prompt in conversations:
    # print(prompt)
    print('Prompt: ' + prompt[1])
    print('Response: ' + prompt[2])