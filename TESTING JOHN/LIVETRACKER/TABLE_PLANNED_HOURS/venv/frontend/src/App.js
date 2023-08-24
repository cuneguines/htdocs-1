import logo from './logo.svg';
import './App.css';
import React, { useState, useEffect } from 'react';
import axios from 'axios';

function App() {
  const [selectedOption, setSelectedOption] = useState('');
  const [data, setData] = useState([]);
  const [idFilter, setIdFilter] = useState('');
  const [nameFilter, setNameFilter] = useState('');
  const [valueFilter, setValueFilter] = useState('');

  const handleSelectChange = (event) => {
    setSelectedOption(event.target.value);
    // Clear filters when a new option is selected
    setIdFilter('');
    setNameFilter('');
    setValueFilter('');
  };

  useEffect(() => {
    // Fetch data from the backend
    axios.get('http://127.0.0.1:5000/api/data') // Replace with your backend API endpoint
      .then(response => {
        setData(response.data);
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
  }, []);

  return (
    <div>
      <h2>Select Example</h2>
      <select value={selectedOption} onChange={handleSelectChange}>
        <option value="">Select an item</option>
        {data.map(item => (
          <option key={item.id} value={item.id}>
            {item.name}
          </option>
        ))}
      </select>
      {selectedOption && <p>You selected: {selectedOption}</p>}

      <div>
        <div>
          <input
            type="text"
            placeholder="Filter by ID"
            value={idFilter}
            onChange={(event) => setIdFilter(event.target.value)}
            onFocus={() => {
              setIdFilter('');
              setNameFilter('');
              setValueFilter('');
            }}
          />
          <input
            type="text"
            placeholder="Filter by Name"
            value={nameFilter}
            onChange={(event) => setNameFilter(event.target.value)}
            onFocus={() => {
              setIdFilter('');
              setNameFilter('');
              setValueFilter('');
            }}
          />
          <input
            type="text"
            placeholder="Filter by Value"
            value={valueFilter}
            onChange={(event) => setValueFilter(event.target.value)}
            onFocus={() => {
              setIdFilter('');
              setNameFilter('');
              setValueFilter('');
            }}
          />
        </div>
        <h2>Table with Backend Data</h2>
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Value</th>
            </tr>
          </thead>
          <tbody>
            {data
              .filter(item =>
                item.id.toString().includes(idFilter) &&
                item.name.includes(nameFilter) &&
                item.value.toString().includes(valueFilter)
              )
              .map(item => (
                <tr key={item.id}>
                  <td>{item.id}</td>
                  <td>{item.name}</td>
                  <td>{item.value}</td>
                </tr>
              ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}

export default App;
