<?php

$telegram = new Telegram('5093425637:AAE8GdwxgE-N9A1Fd_NP7Bac43nPD83VrvE');

$chatId = $telegram->ChatID();
$text = $telegram->Text();
$data = $telegram->getData();
$message = $data['message'];

$user = new User($chatId);
