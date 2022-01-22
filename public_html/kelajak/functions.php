<?php
/** @var $db DbConnect */

$telegram = new Telegram('5093618638:AAGY14XudLumVEebQGImq5rqWw11ywt2xgc');

$data = $telegram->getData();
$message = $data['message'];
$text = $telegram->Text();
$chatId = $telegram->ChatID();

$user = new User($chatId);

$back  = $db->getByKeyword('text', 'back');
$main = $db->getByKeyword('text', 'main');

function showError(){
    global $telegram, $user;

    $errorText = "👇🏼Iltimos tugmalardan birini tanlang👇🏼\n\n👇🏼Пожалуйста, выберите одну из кнопок👇🏼";
    $content  = [
        'chat_id'=>$user->getId(),
        'text'=>$errorText,
    ];

    $telegram->sendMessage($content);
}

function reverceButtons(){
    global $telegram, $user, $db, $back, $main;
    $lang = $user->getLang();
    $text = $db->getByKeyword('text', 'info');

    $buttons  = [[$telegram->buildKeyboardButton($back[$lang]), $telegram->buildKeyboardButton($main[$lang])]];
    $btns = $telegram->buildKeyBoard($buttons, false, true);
    return array('text'=>$text[$lang], 'btns'=>$btns);
}

function showMain(){

    global $telegram, $user;

    $startText = "👇🏼Iltimos tilni tanlang👇🏼\n\n👇🏼Пожалуйста, выберите язык👇🏼";

    $option = [
        [$telegram->buildKeyboardButton(Buttons::BTN_UZ), $telegram->buildKeyboardButton(Buttons::BTN_RU)],
    ];

    $buttons = $telegram->buildKeyBoard($option, false, true);
    $content = [
        'chat_id'=>$user->getId(),
        'text'=>$startText,
        'reply_markup'=>$buttons,
    ];

    $telegram->sendMessage($content);
    $user->setPage(Pages::START);
}



function showOneCenter(){
    global $telegram, $user, $db;

    $lang = $user->getLang();
    $text = $db->getByKeyword('text', 'onecenter');

    $onecenter = $db->getAll(Pages::ONE_CENTER);
    $buttons = Buttons::buttonCreator($onecenter, 2, $lang);

    if ($lang == User::UZ){
        array_push($buttons, [$telegram->buildKeyboardButton(Buttons::BTN_CHANGE_UZ)]);
    }else{
        array_push($buttons, [$telegram->buildKeyboardButton(Buttons::BTN_CHANGE_RU)]);
    }
    $btns = $telegram->buildKeyBoard($buttons, false, true);

    $telegram->sendMessage([
        'chat_id'=>$user->getId(),
        'text'=>$text[$lang],
        'reply_markup'=>$btns
    ]);


    $user->setPage(Pages::ONE_CENTER);
}





function showLocation(){
    global $telegram, $user, $db;


    $telegram->sendMessage([
        'chat_id'=>$user->getId(),
        'text'=>"Manzil: 
        Yozyovon shaharchasi eski Kelajak to'yhonasi o'rni
        Telefonlar: +998 91 670-20-89
                    +998 90 302-40-44
                    +998 99 691-22-30
        ",
    ]);

    $telegram->sendLocation([
        'chat_id'=>$user->getId(),
        'latitude'=>Pages::LOCATE['latitude'],
        'longitude'=>Pages::LOCATE['longitude']
    ]);


    $telegram->sendMessage([
        'chat_id'=>$user->getId(),
        'text'=>reverceButtons()['text'],
        'reply_markup'=>reverceButtons()['btns'],
    ]);

    $user->setPage(Pages::LOCATION);
}

function showPhone(){
    global $telegram, $user, $db;


    $telegram->sendMessage([
        'chat_id'=>$user->getId(),
        'text'=>"Telefonlar: +998 91 670-20-89
                    +998 90 302-40-44
                    +998 99 691-22-30
        ",
    ]);

    $telegram->sendMessage([
        'chat_id'=>$user->getId(),
        'text'=>reverceButtons()['text'],
        'reply_markup'=>reverceButtons()['btns'],
    ]);

    $user->setPage(Pages::PHONE);
}
