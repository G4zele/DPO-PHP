<?php

require_once 'cfg.ini';

try {
    $configArray = parse_ini_file('cfg.ini');
    $dsn = "pgsql:host={$configArray['host']};port={$configArray['port']};dbname={$configArray['dbname']}";
    $dbh = new PDO($dsn, $configArray['username'], $configArray['passwd']);
} catch (PDOException $e) {
    echo 'Произошла ошибка при подключении к базе данных.';
    die();
}

$selectQuery = $dbh->prepare("SELECT * FROM public.news WHERE ID = :id");
$selectQuery->bindParam(':id', $_POST['id']);
$status = $selectQuery->execute();

if ($status) {
    $data = $selectQuery->fetchAll();

    foreach ($data as $url) {
        echo 'ID: ' . $url['ID'] . '<br>';
        echo 'URL: ' . $url['ref'] . '<br><br>';
    }
} else {
    echo 'Данные не найдены.';
}
