<?php

function setLang($chatId, $lang){
    file_put_contents('files/'.$chatId.'lang.txt', $lang);
}

function getLang($chatId){
   return file_get_contents('files/'.$chatId.'lang.txt');
}

function setStep($chatId, $page){
    file_put_contents('files/'.$chatId.'page.txt', $page);
}

function getStep($chatId){
    return file_get_contents('files/'.$chatId.'page.txt');
}
