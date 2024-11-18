<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 100px;
        }
        button {
            padding: 15px 30px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<h1>Панель администратора</h1>
<div class="container">
    <a href="{{ route('admin.create.house') }}" class="btn btn-primary">Создать новый дом</a>
    <a href="{{ route('admin.create.meeting') }}" class="btn btn-primary">Создать новое собрание</a>
{{--    <a href="{{ route('showVotes') }}" class="btn btn-primary">Посмотреть результаты собрания</a>--}}
</div>
</body>
</html>
