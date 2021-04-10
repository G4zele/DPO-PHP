<?php

require 'functionBetBalance.php';

// Считываем данные тестов
$inputInfo = glob("data/*.dat");
$outputInfo = glob("data/*.ans");

$index = 1;

// Создаём массив для сравнения ответов
foreach (array_combine($inputInfo,$outputInfo) as $input => $output) 
{
    $fs = fopen($output, 'r');
    $rightAnswer = trim(fgets($fs), " ");
    $programAnswer = getFinalBalance($input);
    echo "<p>Test $index: ";
    if ($rightAnswer == $programAnswer) 
    {
        echo "I got It.</p>";
    } 
    else 
    {
        echo "I guess, I didn't got it.</p><p>Right answer: $rightAnswer.</p><p>Programm answer: $programAnswer.</p>";
    }
    $index++;
}
?>