<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login KostQu</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 320px;
        }

        .login-box h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 600;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #3b82f6;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2563eb;
        }

        .error {
            color: red;
            font-size: 0.9em;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="login-box">
        <h2>Login KostQu</h2>

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Masuk</button>
        </form>
    </div>

</body>
</html>
