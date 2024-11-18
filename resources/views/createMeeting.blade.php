<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание новой встречи</title>
</head>
<body>
<h1>Создание новой встречи</h1>

<form action="{{ route('admin.store.meeting') }}" method="POST">
    @csrf

    <div>
        <label for="house_name">Название дома:</label>
        <select name="house_name" id="house_name">
            @foreach ($houses as $house)
                <option value="{{ $house->house_name }}">{{ $house->house_name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="date">Дата встречи:</label>
        <input type="date" id="date" name="date" required>
    </div>

    <div>
        <label for="question">Вопрос:</label>
        <textarea id="question" name="question" required></textarea>
    </div>

    <button type="submit">Создать встречу</button>
</form>
</body>
</html>
