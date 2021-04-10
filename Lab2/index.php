<?php

// Устанавливаем соединение с БД
try {
    $configArray = parse_ini_file('cfg.ini');
    // var_dump($configArray);
    $dsn = "pgsql:host={$configArray['host']};port={$configArray['port']};dbname={$configArray['dbname']}";
    $dbconn = new PDO($dsn, $configArray['username'], $configArray['passwd']);
} catch (PDOException $e) {
    echo $e->getMessage();
}

// Создаём экземпляр XML-парсера
$xml = simplexml_load_file('input.xml');
// var_dump($xml);
// Подготавливаем запрос вставки
$insertQuery = $dbconn->prepare("INSERT INTO public.books(
	id, author, title, genre, price, publish_date, description)
	VALUES (:id, :author, :title, :genre, :price, :publish_date, :description);");
// Перебираем каждого пользователя и вносим записи в БД
foreach ($xml as $book) 
{
    $insertQuery->bindParam(':id', $book->id);
    $insertQuery->bindParam(':author', $book->author);
    $insertQuery->bindParam(':title', $book->title);
    $insertQuery->bindParam(':genre', $book->genre);
    $insertQuery->bindParam(':price', $book->price);
    $insertQuery->bindParam(':publish_date', $book->publish_date);
    $insertQuery->bindParam(':description', $book->description);
    try {
        $insertQuery->execute();
        echo "<p>Successfully inserted.</p>";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// Подготавливаем запрос выборки
$selectQuery = $dbconn->prepare("SSELECT id, author, title, genre, price, publish_date, description
FROM public.books;");
$selectQuery->execute();
// Считываем данные из БД
$results = $selectQuery->fetchAll(PDO::FETCH_ASSOC);
// Получаем строку JSON-представления
$json = json_encode($results, JSON_UNESCAPED_UNICODE);
// Записывает в файл
file_put_contents('res.json', $json);
?>