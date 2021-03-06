<?php

require_once('connect.php');

// Отлично! Нам осталось всего лишь проитерировать всё то же самое для 144 блоков.
// Для этого создаём простейший цикл.

$last = daemonQuery('getblockcount');

$tx_count = 0;

for ($i = $last; $i > $last - 144; $i--)
{
	$hash = daemonQuery('getblockhash', [$i]);
	$info = daemonQuery('getblock', [$hash]);
	$tx_count += count($info['tx']);
}

echo $tx_count;

// Задачу мы решили.
// Как можно это всё улучшить?
// В первую очередь -- задача была "посчитать за последние сутки", а мы посчитали за последние 144 блока.
// Блоки содержат временные метки (unix time). Поэтому на самом деле достаточно цикла do .. while, который будет останавливаться
// как только получит значение времени менее, чем "сейчас" за вычетом 60*60*24 секунд.