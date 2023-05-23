<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Space Booking Calendar</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <style>
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 20px;
}

h1 {
  text-align: center;
}

#calendar {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  grid-gap: 10px;
  margin-top: 20px;
}

.day {
  border: 1px solid #ccc;
  padding: 10px;
}

.day .date {
  font-weight: bold;
  margin-bottom: 5px;
}

.day .bookings {
  margin-top: 10px;
}

.bookings p {
  margin: 0;
}
</style>
  <h1>Space Booking Calendar</h1>
  <div id="calendar"></div>

  <script src="./script.js"></script>
</body>
</html>