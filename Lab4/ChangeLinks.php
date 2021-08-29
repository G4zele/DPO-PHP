<?php

require_once 'cfg.ini';

// Шаблон для поиска ссылок
$pattern = "/(\d+-*\d+)/";

// Устанавливаем соединение с БД
try {
    $configArray = parse_ini_file('cfg.ini');
    $dsn = "pgsql:host={$configArray['host']};port={$configArray['port']};dbname={$configArray['dbname']}";
    $dbh = new PDO($dsn, $configArray['username'], $configArray['passwd']);
} catch (PDOException $e) {
    echo 'Произошла ошибка при подключении к базе данных.';
    die();
}

// Формируем запрос выборки из БД
$selectQuery = $dbh->prepare("SELECT * FROM public.news ORDER BY id ASC ");
$selectQuery->execute();
$links = $selectQuery->fetchAll();

// Меняем ссылки по шаблону
foreach ($links as $link) {
    $newlinkId = [];
    if (preg_match($pattern, $link['ref'], $newlinkId)) {
        $newlink = 'https://sozd.parlament.gov.ru/bill/' . $newlinkId[0];
        $updateQuery = $dbh->prepare("UPDATE news SET ref = :ref WHERE id = :id");
        $updateQuery->bindParam(':ref', $newlink);
        $updateQuery->bindParam(':id', $link['ID']);
        $status = $updateQuery->execute();
        if ($status) {
            echo 'Ссылка ID = ' . $link['ID'] . ' заменена.<br>';
        } else {
            echo 'Ссылка ID = ' . $link['ID'] . ' не заменена.<br>';
        }
    }
}
