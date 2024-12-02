<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить помещение</title>
</head>
<body>
<h1>Добавить помещение</h1>
<form action="{{ route('user.saveFlat') }}" method="POST">
    @csrf
    <label for="house_id">Выберите дом:</label>
    <select name="house_id" id="house_id" required>
        <option value="">Выберите дом</option>
        @foreach ($houses as $house)
            <option value="{{ $house->house_id }}">{{ $house->house_name }}</option>
        @endforeach
    </select>

    <label for="apartment_number">Выберите квартиру:</label>
    <select name="apartment_number" id="flat_id" required>
        <option value="">Сначала выберите дом</option>
    </select>

    <label for="area_of_the_apartment">Площадь:</label>
    <input type="number" step="1.0" id="area_of_the_apartment" name="area_of_the_apartment" required>

    <label for="ownership_percentage">Доля в праве (%):</label>
    <input type="number" step="1.0" id="ownership_percentage" name="ownership_percentage" value="100" required>

    <button type="submit">Сохранить</button>
</form>

<script>
    document.getElementById('house_id').addEventListener('change', function () {
        const houseId = this.value;
        const flatSelect = document.getElementById('flat_id');
        if (houseId) {
            fetch(`/getFlats/${houseId}`)
                .then(response => response.json())
                .then(data => {
                    flatSelect.innerHTML = '<option value="">-- Выберите квартиру --</option>';
                    data.apartments.forEach(flat => {
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
