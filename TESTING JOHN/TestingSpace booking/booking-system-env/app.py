from flask import Flask, jsonify, request
import json

app = Flask(__name__)

@app.route('/api/bookings', methods=['GET'])
def get_bookings():
    with open('backend/bookings.json') as f:
        bookings = json.load(f)
    return jsonify(bookings)

if __name__ == '__main__':
    app.run()
