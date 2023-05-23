
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Space Booking</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }

    h1 {
      text-align: center;
    }

    form {
      max-width: 400px;
      margin: 0 auto;
    }

    label, input, select {
      display: block;
      margin-bottom: 10px;
    }

    input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <h1>Space Booking</h1>
  <form action="process_booking.php" method="post">
    <label for="name">Your Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email Address:</label>
    <input type="email" id="email" name="email" required>

    <label for="date">Booking Date:</label>
    <input type="date" id="date" name="date" required>

    <label for="start-time">Start Time:</label>
    <input type="time" id="start-time" name="start-time" required>

    <label for="end-time">End Time:</label>
    <input type="time" id="end-time" name="end-time" required>

    <label for="space">Space Type:</label>
    <select id="space" name="space" required>
      <option value="">Select a space type</option>
      <option value="conference">Conference Room</option>
      <option value="auditorium">Auditorium</option>
      <option value="classroom">Classroom</option>
    </select>

    <input type="submit" value="Submit">
  </form>
</body>
</html>