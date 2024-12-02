<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Информация о квартире</title>
</head>
<body>
<h1>Информация о квартире</h1>
<p>Дом: {{ $flat->house->house_name }}</p>
<p>Квартира: {{ $flat->apartment_number }}</p>
<p>Площадь: {{ $flat->area_of_the_apartment }} м²</p>
<p>
    Доля в праве:
    @if ($ownership && $ownership->pivot)
        {{ $ownership->pivot->ownership_percentage }}%
    @else
        Не указано
    @endif
</p>

<h2>Редактировать данные</h2>
<form method="POST" action="{{ route('user.flat.update', $flat->flat_id) }}">
    @csrf
    <label for="area_of_the_apartment">Площадь квартиры (м²):</label>
    <input type="number" step="1.0" id="area_of_the_apartment" name="area_of_the_apartment"
           value="{{ $flat->area_of_the_apartment }}" required>

    <label for="ownership_percentage">Доля в праве (%):</label>
    <input type="number" step="1.0" id="ownership_percentage" name="ownership_percentage"
           value="{{ $ownership && $ownership->pivot ? $ownership->pivot->ownership_percentage : '' }}" required>

    <button type="submit">Сохранить изменения</button>
</form>

<form method="POST" action="{{ route('user.flat.removeOwner', $flat->flat_id) }}">
    @csrf
    <button type="submit" onclick="return confirm('Вы уверены, что хотите удалить связь с этим помещением?')">Удалить помещение</button>
</form>

<a href="{{ route('user.page') }}">
    <button>Назад</button>
</a>
</body>
</html>
