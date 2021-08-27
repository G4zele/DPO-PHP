<?php
$to = 'grandidenhic@gmail.com';
$subject = "=?utf-8?B?".base64_encode("Оповещение с сайта")."?=";
$message = $_POST['comment'];
$headers = array(
    'From' => $_POST['email'],
    'Reply-to' => $_POST['email'],
    'Content-type' => 'text/html',
);

$fio = explode(" ", $_POST['fio']);

// Устанавливаем соединение с БД
try {
    $configArray = parse_ini_file('cfg.ini');
    // var_dump($configArray);
    $dsn = "pgsql:host={$configArray['host']};port={$configArray['port']};dbname={$configArray['dbname']}";
    $dbh = new PDO($dsn, $configArray['username'], $configArray['passwd']);
} catch (PDOException $e) {
    echo 'Произошла ошибка при подключении к базе данных.';
    die();
}

$allowenceTime = date("Y-m-d H:i:s", strtotime('-1 hours'));
$selectQuery = $dbh->prepare("SELECT * FROM data WHERE email = :email AND time > :time ORDER BY time DESC");
$selectQuery->bindParam(':email', $_POST['email']);
$selectQuery->bindParam(':time', $allowenceTime);
$selectQuery->execute();
$row = $selectQuery->fetchAll();

// Подготавливаем запрос вставки
if (count($row) == 0) {
    $insertQuery = $dbh->prepare("INSERT INTO public.\"dpoPhpLab3\"(
        surname, name, patronymic, email, phone, comment, \"time\") VALUES (:surname, :name, :patronymic, :email, :phone, :comment, :time)");

    $insertQuery->bindParam(':surname', $fio[0]);
    $insertQuery->bindParam(':name', $fio[1]);
    $insertQuery->bindParam(':patronymic', $fio[2]);
    $insertQuery->bindParam(':email', $_POST['email']);
    $insertQuery->bindParam(':phone', $_POST['phone']);
    $insertQuery->bindParam(':comment', $_POST['comment']);
    $insertQuery->bindParam(':time', date("Y-m-d H:i:s"));

    $status = $insertQuery->execute();

    // Если добавление в БД произошло, отправляем письмо
    if ($status) {
        mail($to, $subject, $message, $headers);
        echo 'success';
    } else {
        echo 'Произошла ошибка при добавлении записи в базу данных.';
    }
} else {
    $now = strtotime(date("Y-m-d H:i:s"));
    $publicationTime = strtotime($row[0]['time']);
    $timeDifference = ($now - $publicationTime) / 60;
    echo 'Повторите попытку через ' . round(60 - $timeDifference) . ' минут.';
}