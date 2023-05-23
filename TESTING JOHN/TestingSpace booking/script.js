// Example data - replace with your own booking data
const bookings = [
    {
      date: '2023-05-20',
      startTime: '10:00',
      endTime: '12:00',
      space: 'conference',
      name: 'John Doe',
      email: 'johndoe@example.com'
    },
    {
      date: '2023-05-21',
      startTime: '14:00',
      endTime: '16:00',
      space: 'auditorium',
      name: 'Jane Smith',
      email: 'janesmith@example.com'
    }
  ];
  
  document.addEventListener('DOMContentLoaded', function() {
    const calendar = document.getElementById('calendar');
  
    // Get current date
    const currentDate = new Date();
  
    // Get the first day of the month
    const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
  
    // Get the number of days in the month
    const numberOfDays = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
  
    // Get the day of the week of the first day
    const firstDayOfWeek = firstDayOfMonth.getDay();
  
    // Create the calendar grid
    for (let i = 0; i < firstDayOfWeek; i++) {
      const emptyDay = document.createElement('div');
      emptyDay.classList.add('day');
      calendar.appendChild(emptyDay);
    }
  
    for (let day = 1; day <= numberOfDays; day++) {
      const date = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
  
      const calendarDay = document.createElement('div');
      calendarDay.classList.add('day');
      calendarDay.innerHTML = `<div class="date">${day}</div>`;
      
      const bookingsForDay = bookings.filter(booking => booking.date === date.toISOString().slice(0, 10));
      if (bookingsForDay.length > 0) {
        const bookingsContainer = document.createElement('div');
        bookingsContainer.classList.add('bookings');
        bookingsForDay.forEach(booking => {
          const bookingInfo = document.createElement('p');
          bookingInfo.innerHTML = `<strong>${booking.startTime} - ${booking.endTime}</strong>: ${booking.space}`;
          bookingsContainer.appendChild(bookingInfo);
        });
        calendarDay.appendChild(bookingsContainer);
    }
    
    calendar.appendChild(calendarDay);
  }
});