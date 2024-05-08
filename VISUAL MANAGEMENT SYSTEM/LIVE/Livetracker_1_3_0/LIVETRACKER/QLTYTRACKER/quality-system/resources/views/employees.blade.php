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

    <form method="POST" action="{{ route('login') }}">
    @csrf

    <label for="firstname">First Name</label>
    <input type="text" name="firstname" required>

    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" required>

    <label for="login">Login</label>
    <input type="text" name="login" required>

    <label for="clocknumber">Clock Number</label>
    <input type="text" name="clocknumber" required>

    <label for="department">Department</label>
    <select name="department" required>
        <option value="">Select Department</option>
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
    </select>

    <label for="role">Role</label>
    <select name="role" required>
        <option value="">Select Role</option>
        <!-- Add options for different roles as needed -->
        <option value="Admin">Admin</option>
        <option value="Employee">Employee</option>
        <option value="Manager">Manager</option>
    </select>

    @error('login')
        <div>{{ $message }}</div>
    @enderror

    <button type="submit">Login</button>
</form>

</body>
</html>
