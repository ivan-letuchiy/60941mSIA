<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация владельца</title>
</head>
<body>
<h1>Регистрация владельца</h1>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('user.registration.submit') }}" method="POST">
    @csrf
    <div>
        <label for="full_name">ФИО:</label>
        <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" required>
        @error('full_name')
        <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="house_id">Выберите дом:</label>
        <select name="house_id" id="house_id" required>
            <option value="">-- Выберите дом --</option>
            @foreach($houses as $house)
                <option value="{{ $house->house_id }}" {{ old('house_id') == $house->house_id ? 'selected' : '' }}>
                    {{ $house->house_name }}
                </option>
            @endforeach
        </select>
        @error('house_id')
        <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="flat_id">Выберите квартиру:</label>
        <select name="flat_id" id="flat_id" required>
            <option value="">-- Сначала выберите дом --</option>
            <!-- Flats будут подгружены через AJAX -->
        </select>
        @error('flat_id')
        <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="area_of_the_apartment">Площадь квартиры:</label>
        <input type="number" name="area_of_the_apartment" id="area_of_the_apartment" value="{{ old('area_of_the_apartment') }}" required>
        @error('area_of_the_apartment')
        <div>{{ $message }}</div>
        @enderror
    </div>

    <button type="submit">Зарегистрировать</button>
</form>

<script>
    document.getElementById('house_id').addEventListener('change', function() {
        let houseId = this.value;
        let flatSelect = document.getElementById('flat_id');

        console.log("Selected House ID: ", houseId); // Проверка выбранного ID

        if (houseId) {
            fetch(`/getFlats/${houseId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Received Flats Data: ", data); // Проверка данных
                    flatSelect.innerHTML = '<option value="">-- Выберите квартиру --</option>';
                    data.forEach(flat => {
                        flatSelect.innerHTML += `<option value="${flat.flat_id}">${flat.apartment_number}</option>`;
                    });
                })
                .catch(error => {
                    console.error("Error fetching flats: ", error);
                });
        } else {
            flatSelect.innerHTML = '<option value="">-- Сначала выберите дом --</option>';
        }
    });
</script>
</body>
</html>
