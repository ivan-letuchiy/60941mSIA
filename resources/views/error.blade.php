<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ошибка</title>
</head>
<body>
<h1>Ошибка</h1>
@if (session('error'))
    <p>{{ session('error') }}</p>
@endif
</body>
</html>
