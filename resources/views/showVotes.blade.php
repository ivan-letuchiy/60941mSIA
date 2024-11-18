!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результаты голосования</title>
</head>
<body>
<select id="house_select">
    <option value="">Выберите дом</option>
    @foreach ($houses as $house)
        <option value="{{ $house->house_id }}">{{ $house->house_name }}</option>
    @endforeach
</select>

<!-- Выпадающий список для собраний -->
<select id="meeting_select" disabled>
    <option value="">Выберите сначала дом</option>
</select>

<!-- Заголовок вопроса собрания -->
<h3 id="question_title" style="display:none;"></h3>

<!-- Таблица с результатами голосования -->
<table id="votes_table" style="display:none;">
    <thead>
    <tr>
        <th>Номер квартиры</th>
        <th>Собственники квартиры</th>
        <th>Голос</th>
    </tr>
    </thead>
    <tbody>
    <!-- Данные будут динамически заполняться через JS -->
    </tbody>
</table>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var houseSelect = document.getElementById('house_select');
        var meetingSelect = document.getElementById('meeting_select');
        var questionTitle = document.getElementById('question_title');
        var votesTable = document.getElementById('votes_table');
        var votesTableBody = votesTable.querySelector('tbody');

        // Обработчик для выбора дома
        houseSelect.addEventListener('change', function () {
            var houseId = this.value;
            if (houseId) {
                fetch('{{ route('admin.getMeetings') }}?house_id=' + houseId)
                    .then(response => response.json())
                    .then(data => {
                        meetingSelect.innerHTML = '<option value="">Выберите собрание</option>';

                        // Обрабатываем каждый элемент данных
                        data.forEach(function (meeting) {
                            var option = document.createElement('option');
                            option.value = meeting.meeting_id; // Значение - meeting_id
                            option.textContent = meeting.date; // Отображаем текст - дата
                            meetingSelect.appendChild(option);
                        });

                        meetingSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Ошибка при загрузке собраний');
                    });
            } else {
                meetingSelect.innerHTML = '<option value="">Выберите сначала дом</option>';
                meetingSelect.disabled = true;
            }
        });

        // Обработчик для выбора собрания
        meetingSelect.addEventListener('change', function () {
            var meetingId = this.value; // Используем meeting_id как значение

            if (meetingId) {
                // Выполняем запрос для получения голосов по выбранному собранию
                fetch('{{ route('admin.getVotes') }}?meeting_id=' + meetingId) // Используем meeting_id в запросе
                    .then(response => response.json())
                    .then(data => {
                        // Показываем вопрос собрания
                        questionTitle.textContent = data.question;
                        questionTitle.style.display = 'block';

                        // Очищаем таблицу перед заполнением
                        votesTableBody.innerHTML = '';

                        // Заполняем таблицу данными
                        data.votes.forEach(function (vote) {
                            var row = document.createElement('tr');

                            // Номер квартиры
                            var apartmentCell = document.createElement('td');
                            apartmentCell.textContent = vote.ownerVote.flat_number;
                            row.appendChild(apartmentCell);

                            // Собственники квартиры
                            var ownersCell = document.createElement('td');
                            ownersCell.textContent = vote.ownerVote.full_name;
                            row.appendChild(ownersCell);

                            // Голос
                            var voteCell = document.createElement('td');
                            voteCell.textContent = vote.answer;
                            row.appendChild(voteCell);

                            votesTableBody.appendChild(row);
                        });

                        // Показываем таблицу
                        votesTable.style.display = 'table';
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Ошибка при загрузке голосов');
                    });
            } else {
                // Если собрание не выбрано, скрываем таблицу и заголовок
                questionTitle.style.display = 'none';
                votesTable.style.display = 'none';
                votesTableBody.innerHTML = '';
            }
        });
    });
</script>
</body>
</html>
