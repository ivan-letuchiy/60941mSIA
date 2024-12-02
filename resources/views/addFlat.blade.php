<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить помещение</title>
    <script>
        // Функция для обновления списка квартир
        function updateApartments(house_id) {
            const apartmentSelect = document.getElementById("apartment_number");
            apartmentSelect.innerHTML = "";  // Очищаем текущий список квартир

            fetch(`/user/get-apartments/${house_id}`)
                .then(response => response.json())
                .then(data => {
                    data.apartments.forEach(flat => {
                        const option = document.createElement("option");
                        option.value = flat.flat_id;
                        option.textContent = `Квартира ${flat.apartment_number}`;
                        apartmentSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Ошибка при загрузке квартир:', error));
        }
    </script>
</head>
<body>
<h1>Добавить помещение</h1>
<form action="{{ route('user.saveFlat') }}" method="POST">
    @csrf
    <label for="house_id">Выберите дом:</label>
    <select name="house_id" id="house_id" onchange="updateApartments(this.value)" required>
        <option value="">Выберите дом</option>
        @foreach ($houses as $house)
            <option value="{{ $house->house_id }}">{{ $house->house_name }}</option>
        @endforeach
    </select>

    <label for="apartment_number">Выберите квартиру:</label>
    <select name="apartment_number" id="apartment_number" required>
        <option value="">Выберите квартиру</option>
    </select>

    <label for="area_of_the_apartment">Площадь:</label>
    <input type="number" step="0.01" id="area_of_the_apartment" name="area_of_the_apartment" required>

    <label for="ownership_percentage">Доля в праве (%):</label>
    <input type="number" step="0.01" id="ownership_percentage" name="ownership_percentage" value="100" required>

    <button type="submit">Сохранить</button>
</form>
</body>
</html>
