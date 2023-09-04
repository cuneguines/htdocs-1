import logo from './logo.svg';
import './App.css';
import React, { useState, useEffect } from 'react';
import axios from 'axios';
//Define the Greeting component
function Greeting(props) {
  return <p>Hello, {props.name}!</p>;
}

// Define the ItemList component
function ItemList(props) {
  const items = props.items.map((item, index) => (
    <li key={index}>{item}</li>
  ));

  return <ul>{items}</ul>;
}

function App() {
  const [selectedOption, setSelectedOption] = useState('');
  const [data, setData] = useState([]);
  const [idFilter, setIdFilter] = useState('');
  const [nameFilter, setNameFilter] = useState('');
  const [valueFilter, setValueFilter] = useState('');
  const items = ['Apples', 'Bananas', 'Oranges', 'Grapes']; // List of items

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
    <div >
      <h2>Select Example</h2>
      <select value={selectedOption} onChange={handleSelectChange}>
        <option value="">ALL</option>
        {data.map(item => (
          <option key={item.id} value={item.id}>
            {item.name}
          </option>
        ))}
      </select>
      {selectedOption && <p>You selected: {selectedOption}</p>}

      <div const style={tableDiv}>
       
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
                item.name.includes(selectedOption) &&
                item.value.toString().includes(valueFilter)
              )
              .map(item => (
                <tr name={item.id} value={item.value}key={item.id}>
                  <td class='first'>{item.id}</td>
                  <td>{item.name}</td>
                  <td>{item.value}</td>
                </tr>
              ))}
          </tbody>
        </table>
      </div>
      <div const style={styles}>
          
      <select style={{marginLeft:'200px',...styles_input}}value={selectedOption} onChange={handleSelectChange}>
        <option value="">ALL</option>
        {data.map(item => (
          <option key={item.id} value={item.id}>
            {item.name}
          </option>
        ))}
      </select>
        
          <input style={{marginLeft:'200px',...styles_input}}
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
          <input style={{marginLeft:'200px',...styles_input}}
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
      
  
 
    <div>
      <h1>Hello, React!</h1>
      <Greeting name="Alice" />
      <Greeting name="Bob" />
      <ItemList items={items} /> {/* Pass the items prop */}
    </div>




    </div>
  );
}
const styles = {
  background: 'white',
  padding: '10px',
  borderBottom: '1px solid #ddd',
  textAlign: 'left',
  fontSize: '8px',
  boxShadow: '-1px -1px 6px green, 0 3px 12px 20px rgba(0, 0, 0, 0.23)',
  color:'black',
  position: 'sticky',
  

};
const styles_input = {
  background: 'white',
  padding: '10px',
  borderBottom: '1px solid #ddd',
  textAlign: 'left',
  
 borderRadius:'50px',
  color:'black',
  position: 'sticky',
  
width:'400px'
};
const tableDiv={
height:'800px'
}
export default App;
