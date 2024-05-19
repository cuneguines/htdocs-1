<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Employee</title>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Create Employee</h1>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form action="/employees" method="post">
        @csrf
        <div>
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>
        </div>
        <div>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>
        </div>
        <div>
            <label for="login">Login:</label>
            <input type="text" id="login" name="login" required>
        </div>
        <div>
            <label for="clock_number">Clock Number:</label>
            <input type="text" id="clock_number" name="clock_number" required>
        </div>
        <div>
            <label for="department">Department:</label>
            <select id="department" name="department" required>
                <option value="">Select Department</option>
                <option value="01-Fabrication 1">01-Fabrication 1</option>
                <option value="02-Material Prep">02-Material Prep</option>
                <option value="03-HR">03-HR</option>
                <option value="04-Supply Chain">04-Supply Chain</option>
                <!-- Add more options as needed -->
            </select>
        </div>
        <div>
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="">Select Role</option>
                <option value="Admin">Admin</option>
                <option value="Manufacturing">Manufacturing</option>
                <option value="Quality">Quality</option>
                <option value="Other">Other</option>
                <!-- Add more options as needed -->
            </select>
        </div>
        <button type="submit">Submit</button>
    </form>
    <button type="button" onclick="view()">View</button>

    <!-- Table to display employee data -->
    <table border="1" id="employeeTable" style="display: none;">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Login</th>
                <th>Clock Number</th>
                <th>Department</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
        // Ensure CSRF token is included in AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function view() {
            $.ajax({
                url: '/getemployee', // Adjust URL as needed
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    // Show the table
                    $('#employeeTable').show();
                    
                    // Clear existing table rows
                    $('#employeeTable tbody').empty();

                    // Iterate over the response data and append rows to the table
                    $.each(response.data, function(index, employee) {
                        $('#employeeTable tbody').append(`
                            <tr>
                                <td>${employee.FirstName}</td>
                                <td>${employee.LastName}</td>
                                <td>${employee.login}</td>
                                <td>${employee.ClockNumber}</td>
                                <td>${employee.Department}</td>
                                <td>${employee.Role}</td>
                            </tr>
                        `);
                    });
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
    </script>
</body>
</html>
