<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание собрания</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        form {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            cursor: pointer;
            background-color: #007BFF;
            color: white;
        }

        button:hover {
            background-color: #0056b3;
        }

        .question {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }

        .answers {
            margin-top: 10px;
        }

        .answers input {
            width: calc(100% - 30px);
            margin-bottom: 5px;
            display: inline-block;
        }

        .add-answer {
            width: auto;
            margin-left: 10px;
            display: inline-block;
        }

        .add-question {
            margin-top: 20px;
            width: auto;
        }
    </style>
</head>
<body>
<form action="{{ route('admin.store.meeting') }}" method="POST">
    @csrf
    <h2>Создание собрания</h2>

    <!-- Выбор дома -->
    <div>
        <label for="house_id">Дом:</label>
        <select name="house_id" id="house_id" required>
            <option value="">Выберите дом</option>
            @foreach($houses as $house)
                <option value="{{ $house->house_id }}">{{ $house->house_name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Выбор даты -->
    <div>
        <label for="date">Дата собрания:</label>
        <input type="date" name="date" id="date" required>
    </div>

    <!-- Блок для вопросов -->
    <div id="questions-container">
        <div class="question">
            <label>Вопрос:</label>
            <input type="text" name="questions[0][text]" placeholder="Введите вопрос" required>
            <div class="answers">
                <label>Варианты ответа:</label>
                <input type="text" name="questions[0][answers][]" placeholder="Введите вариант ответа" required>
                <button type="button" class="add-answer">Добавить вариант</button>
            </div>
        </div>
    </div>

    <!-- Кнопка для добавления нового вопроса -->
    <button type="button" class="add-question" id="add-question">Добавить вопрос</button>

    <!-- Кнопка отправки формы -->
    <button type="submit">Сохранить собрание</button>
</form>

<script>
    // Добавление нового вопроса
    document.getElementById('add-question').addEventListener('click', () => {
        const questionsContainer = document.getElementById('questions-container');
        const questionCount = questionsContainer.children.length;

        const newQuestion = `
                <div class="question">
                    <label>Вопрос:</label>
                    <input type="text" name="questions[${questionCount}][text]" placeholder="Введите вопрос" required>
                    <div class="answers">
                        <label>Варианты ответа:</label>
                        <input type="text" name="questions[${questionCount}][answers][]" placeholder="Введите вариант ответа" required>
                        <button type="button" class="add-answer">Добавить вариант</button>
                    </div>
                </div>
            `;
        questionsContainer.insertAdjacentHTML('beforeend', newQuestion);
    });

    // Добавление нового варианта ответа
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('add-answer')) {
            const answersDiv = event.target.closest('.answers');
            const inputName = answersDiv.querySelector('input').name;
            const newAnswer = `
                    <input type="text" name="${inputName}" placeholder="Введите вариант ответа" required>
                `;
            answersDiv.insertAdjacentHTML('beforeend', newAnswer);
        }
    });
</script>
</body>
</html>
