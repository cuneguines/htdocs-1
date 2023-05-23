import React, { useEffect, useState } from 'react';


function App() {
  const [bookings, setBookings] = useState([]);

  useEffect(() => {
    fetch('/api/bookings')
      .then((response) => response.json())
      .then((data) => setBookings(data))
      .catch((error) => console.log(error));
  }, []);

  return (
    <div>
      <h1>Space Booking System</h1>
      <BookingTable bookings={bookings} />
    </div>
  );
}

export default App;
``
