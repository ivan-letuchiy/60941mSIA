<!DOCTYPE html>
<html>
<head>
    <title>Информация о владельце</title>
</head>
<body>
<h1>Информация о владельце: {{ $owner->full_name }}</h1>

<form action="{{ route('owners.update', $owner->owner_id) }}" method="POST">
    @csrf

    <label>ФИО:</label>
    <input type="text" name="full_name" value="{{ $owner->full_name }}" required><br>

    <label>Дом:</label>
    <input type="text" name="house_name" value="{{ $owner->flatsM->first()->house->house_name }}" required><br>

    <label>Номер квартиры:</label>
    <input type="text" name="apartment_number" value="{{ $owner->flatsM->first()->apartment_number }}" required><br>

    <label>Площадь квартиры (м²):</label>
    <input type="number" name="area_of_the_apartment" value="{{ $owner->flatsM->first()->area_of_the_apartment }}" required><br>

    <label>Доля в праве (%):</label>
    <input type="number" name="ownership_percentage" value="{{ $owner->flatsM->first()->pivot->ownership_percentage }}" required><br>

    <button type="submit">Сохранить изменения</button>
</form>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif
</body>
</html>

