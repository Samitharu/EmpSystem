<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="../js/messageBox.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #fff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-container h1 {
            margin-bottom: 30px;
            font-size: 28px;
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            border-color: #6e8efb;
            outline: none;
        }

        .form-group button {
            width: 100%;
            padding: 12px;
            background-color: #6e8efb;
            border: none;
            border-radius: 6px;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group button:hover {
            background-color: #5a75e1;
        }

        .form-group a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #6e8efb;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .form-group a:hover {
            color: #5a75e1;
        }

        .form-group .forgot-password {
            text-align: right;
            margin-top: 10px;
            font-size: 14px;
        }

        #erros_box {
            display: inline-block;
            background-color: red;
            color: white;
            padding: 2px 55px;
            border-radius: 5px;
            text-align: center;
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form action="" method="POST" id="logingForm">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group forgot-password">
                <a href="/#">Forgot Password?</a>
            </div>
            <div class="form-group">
                <button type="button" id="btnLoging">Login</button>
               
            </div>
            <div class="form-group" style="width:300px">
                
                <div id="erros_box" hidden>Invalid E-mail or Password</div>
            </div>
        </form>
    </div>
</body>
</html>
<script src="{{ asset('js/loging.js') }}" defer></script>
