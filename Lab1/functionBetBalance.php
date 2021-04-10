<?php
function getFinalBalance($path)
{
    $fs = fopen($path, 'r');
    $balance = 0;

    // Заполняем данные о ставках
    $betsNum = fgets($fs);
    $bets = [];
    for ($i = 0; $i < $betsNum; $i++) 
    { // Создаём список ставок
        list($gameID, $betAmount, $betRes) = explode(" ", fgets($fs));
        $bets[$gameID]['betAmount'] = (int)$betAmount;
        $bets[$gameID]['betResult'] = trim($betRes, "\n\r");
    }

    // Заполняем данные об играх
    $gamesNum = fgets($fs);
    $games = [];
    for ($i = 0; $i < $gamesNum; $i++) 
    { // Создаём список игр
        list($gameID, $gameKL, $gameKR, $gameKD, $gameRes) = explode(" ", fgets($fs));
        $games[$gameID]['gameCoeffL'] = (float)$gameKL;
        $games[$gameID]['gameCoeffR'] = (float)$gameKR;
        $games[$gameID]['gameCoeffD'] = (float)$gameKD;
        $games[$gameID]['gameResult'] = trim($gameRes, "\n\r");
    }

    // Определяем, прошла ли ставка, и изменяем баланс
    foreach ($bets as $gameID => $bet) 
    {
        if ($bet['betResult'] == $games[$gameID]['gameResult']) 
        {
            $balance += ($games[$gameID]['gameCoeff'.$bet['betResult']] - 1) * $bet['betAmount'];
        } else 
        {
            $balance -= $bet['betAmount'];
        }
    }

    return $balance;
}
?>