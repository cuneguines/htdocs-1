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
            <select name="department" id="department">
                <option value="null">Select Department</option>
                <option value="01-Fabrication 1">01-Fabrication 1</option>
                <option value="02-Material Prep">02-Material Prep</option>
                <option value="03-HR">03-HR</option>
                <option value="04-Supply Chain">04-Supply Chain</option>
                <option value="07-Maintenance">07-Maintenance</option>
                <option value="13-Engineering - Bespoke Products">13-Engineering - Bespoke Products</option>
                <option value="28-Engineering - Drainage">28-Engineering - Drainage</option>
                <option value="29-Engineering - EC & Machine Build">29-Engineering - EC & Machine Build</option>
                <option value="30-Engineering - R&D">30-Engineering - R&D</option>
                <option value="31-Supply Chain 2">31-Supply Chain 2</option>
                <option value="32-Manufacturing Team">32-Manufacturing Team</option>
                <option value="34-Commercial Dept">34-Commercial Dept</option>
                <option value="70-Fabrication 2">70-Fabrication 2</option>
                <option value="Other">Other</option>
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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <!-- Modal for updating employee details -->
    <div id="updateModal" style="display: none;">
        <form id="updateForm">
            <input type="hidden" id="update_id">
            <div>
                <label for="update_first_name">First Name:</label>
                <input type="text" id="update_first_name" name="first_name" required>
            </div>
            <div>
                <label for="update_last_name">Last Name:</label>
                <input type="text" id="update_last_name" name="last_name" required>
            </div>
            <div>
                <label for="update_login">Login:</label>
                <input type="text" id="update_login" name="login" required>
            </div>
            <div>
                <label for="update_clock_number">Clock Number:</label>
                <input type="text" id="update_clock_number" name="clock_number" required>
            </div>
            <div>
                <label for="update_department">Department:</label>
                <select id="update_department" name="department" required>
                    <option value="">Select Department</option>
                    <option value="01-Fabrication 1">01-Fabrication 1</option>
                    <option value="02-Material Prep">02-Material Prep</option>
                    <option value="03-HR">03-HR</option>
                    <option value="04-Supply Chain">04-Supply Chain</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div>
                <label for="update_role">Role:</label>
                <select id="update_role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Manufacturing">Manufacturing</option>
                    <option value="Quality">Quality</option>
                    <option value="Other">Other</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <button type="button" onclick="saveUpdate()">Save</button>
            <button type="button" onclick="closeModal()">Cancel</button>
        </form>
    </div>

    <script>
    // Ensure CSRF token is included in AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function view() {
        $.ajax({
            url: '/getemployee',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                $('#employeeTable').show();
                $('#employeeTable tbody').empty();

                $.each(response.data, function(index, employee) {
                    $('#employeeTable tbody').append(`
                            <tr data-id="${employee.ID}">
                                <td>${employee.FirstName}</td>
                                <td>${employee.LastName}</td>
                                <td>${employee.Login}</td>
                                <td>${employee.ClockNumber}</td>
                                <td>${employee.Department}</td>
                                <td>${employee.Role}</td>
                                <td>
                                    <button type="button" onclick="editEmployee(${employee.ID})">Update</button>
                                    <button type="button" onclick="deleteEmployee(${employee.ID})">Delete</button>
                                </td>
                            </tr>
                        `);
                });
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    function editEmployee(id) {
        console.log(id);
        $.ajax({
            url: `/getemployees/${id}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response);
                const employee = response.data;
                console.log(employee.FirstName);
                $('#update_id').val(employee.ID);
                $('#update_first_name').val(employee.FirstName);
                $('#update_last_name').val(employee.LastName);
                $('#update_login').val(employee.Login);
                $('#update_clock_number').val(employee.ClockNumber);
                $('#update_department').val(employee.Department);
                $('#update_role').val(employee.Role);
                $('#updateModal').show();
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    function saveUpdate() {
        const id = $('#update_id').val();
        const data = {
            first_name: $('#update_first_name').val(),
            last_name: $('#update_last_name').val(),
            login: $('#update_login').val(),
            clock_number: $('#update_clock_number').val(),
            department: $('#update_department').val(),
            role: $('#update_role').val(),
        };

        $.ajax({
            url: `/updateemployee/${id}`,
            type: 'PUT',
            data: data,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                alert('Employee updated successfully');
                $('#updateModal').hide();
                view();
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    function deleteEmployee(id) {
        $.ajax({
            url: `/deleteemployee/${id}`,
            type: 'DELETE',
            dataType: 'json',
            success: function(response) {
                alert(response.success);
                $(`#employeeTable tbody tr[data-id="${id}"]`).remove();
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    function closeModal() {
        $('#updateModal').hide();
    }
    </script>
</body>

</html>