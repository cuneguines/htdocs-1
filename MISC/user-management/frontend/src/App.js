import React, { useState, useEffect } from 'react';

function App() {
  const [message, setMessage] = useState(''); // Initialize with an empty string
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchData = async () => {
      setIsLoading(true);

      try {
        const response = await fetch('http://127.0.0.1:8000/greeting');
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }

        const data = await response.json();

        // Access the "message" property from the JSON response
        setMessage(data.message);
        setIsLoading(false);
      } catch (error) {
        setError(error);
        setIsLoading(false);
      }
    };

    fetchData();
  }, []);

  return (
    <div>
      <h1>Greeting</h1>
      {isLoading && <div>Loading...</div>}
      {error && <div>Error: {error.message}</div>}
      {message && <div>{message}</div>}
    </div>
  );
}

export default App;
