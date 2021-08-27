<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Форма обратной связи</title>
</head>
<body>
    <h1>Форма обратной связи</h1>
    <div class="container">
        <form id="form">
            <input  placeholder="Введите ФИО" type = "text" name = "fio" class = "form-control" id = "fio"><br>
            <input  placeholder="Введите Email" type = "email" name = "email" class = "form-control" id = "email"><br>
            <input placeholder="Введите телефон в формате +7(980)267-99-69" type = "phone" name = "phone" class = "bfh-phone form-control " id = "phone"><br>
            <textarea placeholder="Комментарий" type = "text" name = "comment" class="form-control" id="comment"></textarea><br>
            <button type="button" id="send" class="btn btn-success">Отправить</button>
        </form><br>
        <div id="errorMsg" class="text-danger"></div><br>
        <div id="userMsg" class="text-success"></div><br>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="script.js"></script>
</body>
</html>