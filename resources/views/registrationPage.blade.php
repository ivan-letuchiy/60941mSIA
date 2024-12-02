<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация пользователя</title>
</head>
<body>
<h1>Регистрация пользователя</h1>

@if (session('message'))
    <div>{{ session('message') }}</div>
@endif

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('registration.submit') }}" method="POST">
    @csrf
    <div>
        <label for="full_name">ФИО:</label>
        <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" required>
    </div>
    <div>
        <label for="email">Электронная почта:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>
    </div>
    <div>
        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div>
        <label for="password_confirmation">Подтверждение пароля:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
    </div>
    <div>
        <label for="house_id">Выберите дом:</label>
        <select name="house_id" id="house_id" required>
            <option value="">-- Выберите дом --</option>
            @foreach($houses as $house)
                <option value="{{ $house->house_id }}">{{ $house->house_name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="flat_id">Выберите квартиру:</label>
        <select name="flat_id" id="flat_id" required>
            <option value="">-- Сначала выберите дом --</option>
        </select>
    </div>
    <div>
        <label for="area_of_the_apartment">Площадь квартиры:</label>
        <input type="number" name="area_of_the_apartment" id="area_of_the_apartment" required>
    </div>
    <button type="submit">Зарегистрироваться</button>
</form>

<script>
    document.getElementById('house_id').addEventListener('change', function () {
        let houseId = this.value;
        let flatSelect = document.getElementById('flat_id');

        if (houseId) {
            fetch(`/getFlats/${houseId}`)
                .then(response => response.json())
                .then(data => {
                    flatSelect.innerHTML = '<option value="">-- Выберите квартиру --</option>';
                    data.forEach(flat => {
                        flatSelect.innerHTML += `<option value="${flat.flat_id}">${flat.apartment_number}</option>`;
                    });
                })
                .catch(error => console.error('Ошибка загрузки квартир:', error));
        } else {
            flatSelect.innerHTML = '<option value="">-- Сначала выберите дом --</option>';
        }
    });
</script>
</body>
</html>
