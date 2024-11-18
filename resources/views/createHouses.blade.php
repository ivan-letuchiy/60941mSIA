<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание нового дома с квартирами</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        form {
            width: 300px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50; /* Зеленый цвет */
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<h1>Создание нового дома с квартирами</h1>
<form action="{{ route('admin.store.house') }}" method="POST">
    @csrf
    <div>
        <label for="house_name">Адрес дома:</label>
        <input type="text" id="house_name" name="house_name" required>
    </div>
    <div>
        <label for="start_apartment">Первая квартира:</label>
        <input type="number" id="start_apartment" name="start_apartment" required>
    </div>
    <div>
        <label for="end_apartment">Последняя квартира:</label>
        <input type="number" id="end_apartment" name="end_apartment" required>
    </div>
    <button type="submit">Сохранить дом в базе данных</button>
</form>
</body>
</html>
