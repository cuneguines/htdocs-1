<!-- resources/views/auth/login.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css')}}">

   
</head>
<body>

<style>
    label, input {
            display: block;
            margin-bottom: 8px;
            width: 100%;
            box-sizing: border-box;
        }

        input {
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    button {
            width: 100%;
            padding: 10px;
            background-color: #FACB57;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            border-radius: 20px;
        }

#content {
            width: 300px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 14% 1% 0% 40%;
        }

        </style>
<div id ="background" >
    <div id="content" >
<form method="POST" action="{{ route('login') }}">
    @csrf

    <label for="email">Name</label>
    <input type="text" name="Login" required>

    <label for="password">Password</label>
    <input type="password" name="Password" required>
    @error('Login')
        <div>{{ $message }}</div>
    @enderror

    <button  type="submit">Login</button>
    </form>
</div>
</div>
    </body>
</html>

