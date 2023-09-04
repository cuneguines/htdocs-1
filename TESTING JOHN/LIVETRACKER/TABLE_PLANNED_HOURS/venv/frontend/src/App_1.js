import React, { useState } from 'react';

function ClickExample() {
  const [clickCount, setClickCount] = useState(0);

  const handleClick = (buttonName) => {
    setClickCount(clickCount + 1);
    console.log('Button clicked:', buttonName);
  };

  return (
    <div>
      <h2>Click Example</h2>
      <p>Click Count: {clickCount}</p>
      <button onClick={handleClick}>Click Me</button>
      <h2>Click Example</h2>
      <p>Click Count: {clickCount}</p>
      <button onClick={() => handleClick('Click Me')}>Click Me</button>
      <button onClick={() => handleClick('Another Button')}>Another Button</button>

    </div>


  );
}

export default ClickExample;
