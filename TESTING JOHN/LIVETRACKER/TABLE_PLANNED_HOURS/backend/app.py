from flask import Flask, jsonify

app = Flask(__name__)

@app.route('/api/data', methods=['GET'])
def get_data():
    data = [
        {"id": 1, "name": "Item 1", "value": 10},
        {"id": 2, "name": "Item 2", "value": 20},
        {"id": 3, "name": "Item 3", "value": 30},
    ]
    return jsonify(data)

if __name__ == '__main__':
    app.run()
