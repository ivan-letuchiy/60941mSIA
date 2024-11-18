<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 100px;
            display: flex;
            flex-direction: column
        }
    </style>
</head>
<body>
<h1>Управление многоквартирными домами</h1>
<h2>Создайте аккаунт или войдите в уже существующий</h2>
<div class="container">
    <a href="{{ route('user.registration') }}" class="btn btn-primary">Зарегистрироваться</a>
    <a href="{{ route('owners.index') }}" class="btn btn-primary">Войти</a>
    <a href="{{ route('admin') }}" class="btn btn-primary">Вход для администратора</a>
</div>
</body>
</html>
