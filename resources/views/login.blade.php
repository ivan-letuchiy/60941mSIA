<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
</head>
<body>
@if (Auth::check())
    <h1>Добро пожаловать, {{ Auth::user()->name }}!</h1>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Выйти</button>
    </form>
@else
    <h1>Вход</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
    @if ($errors->any())
        <p>{{ $errors->first() }}</p>
    @endif
@endif
@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
</body>
</html>
