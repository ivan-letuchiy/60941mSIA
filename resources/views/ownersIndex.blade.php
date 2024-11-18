<!DOCTYPE html>
<html>
<head>
    <title>Список владельцев</title>
</head>
<body>
<h1>Выберите владельца</h1>
<form action="">
    <select onchange="window.location.href=this.value;">
        <option value="">-- Выберите владельца --</option>
        @foreach ($owners as $owner)
            <option value="{{ route('owners.show', $owner->owner_id) }}">{{ $owner->full_name }}</option>
        @endforeach
    </select>
</form>
</body>
</html>
