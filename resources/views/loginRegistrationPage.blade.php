<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление многоквартирными домами</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f3f3f3;
        }
        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
        }
        .button-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        button {
            font-size: 1rem;
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<h1>Управление многоквартирными домами</h1>
<div class="button-container">
    <form method="GET" action="{{ route('login') }}">
        <button type="submit">Войти</button>
    </form>
    <form method="GET" action="{{ route('registration.form') }}">
        <button type="submit">Зарегистрироваться</button>
    </form>
</div>
</body>
</html>
