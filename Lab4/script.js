$("#change_number").on("click", function() {
    var str = $("#str").val();

    $.ajax({
        url: 'ChangeNumbers.php', // Исполняемый файл PHP
        type: 'GET', // Тип запроса
        cache: false, // Кэширование
        data: { 'str': str }, // Параметры
        dataType: 'html', // Тип возвращаемого значение
        success: function(data) { // Функция, выполняемая по завершении цикла Ajax
            $("#result").text(data);
        }
    })
})

$("#change_link").on("click", function() {
    $.ajax({
        url: 'ChangeLinks.php', // Исполняемый файл PHP
        type: 'POST', // Тип запроса
        cache: false, // Кэширование
        data: {}, // Параметры
        dataType: 'html', // Тип возвращаемого значение
        success: function(data) { // Функция, выполняемая по завершении цикла Ajax
            $("#references").html(data);
        }
    })
})