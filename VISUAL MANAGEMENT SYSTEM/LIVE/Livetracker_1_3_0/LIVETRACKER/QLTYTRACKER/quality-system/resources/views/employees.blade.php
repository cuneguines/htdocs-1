<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Employee</title>
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
            <label for="department">Role:</label>
            <select id="department" name="department" required>
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
</body>
</html>
