<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
</head>
<body>
<h1>Личный кабинет</h1>
<div>
    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
        @csrf
        <button type="submit">Выйти</button>
    </form>
</div>

<p>Добро пожаловать, {{ $owner->full_name }}</p>

<h2>Выберите квартиру:</h2>
<form method="POST" action="{{ route('user.selectFlat') }}">
    @csrf
    <select name="flat_id" required>
        @foreach ($flats as $flat)
            <option value="{{ $flat->flat_id }}">
                {{ $flat->house->house_name }}, Квартира {{ $flat->apartment_number }}
            </option>
        @endforeach
    </select>
    <button type="submit">Выбрать</button>
</form>
<form action="{{ route('user.addFlatForm') }}" method="GET">
    <button type="submit">Добавить ещё одно помещение</button>
</form>
<form method="POST" action="{{ route('user.deleteAccount') }}" style="display: inline;"
      onsubmit="return confirm('Вы уверены, что хотите удалить аккаунт? Это действие необратимо.')">
    @csrf
    <button type="submit" style="color: red;">Удалить аккаунт</button>
</form>
</body>
</html>

