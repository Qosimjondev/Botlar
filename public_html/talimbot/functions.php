<?php
/** @var $db DbConnect */

$telegram = new Telegram('5067923765:AAEj5uuln1tMem2gnXn8Cv1N6JiQYBivwII');

$data = $telegram->getData();
$message = $data['message'];
$text = $telegram->Text();
$chatId = $telegram->ChatID();

$user = new User($chatId);

$districts = $db->getAll(Pages::DISTRICTS, $user->getLang());
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

function showDistrict(){
    global $telegram, $user, $db, $districts;

    $lang = $user->getLang();

    $text = $db->getByKeyword('text', 'distext');

    $dist = $db->getAll(Pages::DISTRICTS);

    $buttons = Buttons::buttonCreator($dist, 2, $lang);

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

    $user->setPage(Pages::DISTRICTS);
}

function showCenters(){
    global $telegram, $user, $db, $main, $back;

    $lang = $user->getLang();
    $text = $db->getByKeyword('text', 'centertext');


    $dataOne = $db->getAnyOneKeyword(Pages::DISTRICTS, $lang, $user->getDistrict());
    $id = $dataOne['id'];
    $centers = $db->getAnyAllKeyword(Pages::CENTERS, 'district_id', $id);
    $buttons = Buttons::buttonCreator($centers, 2, 'uz');

    array_push($buttons, [$telegram->buildKeyboardButton($back[$lang]), $telegram->buildKeyboardButton($main[$lang])]);
    $btns = $telegram->buildKeyBoard($buttons, false, true);

    $telegram->sendMessage([
        'chat_id'=>$user->getId(),
        'text'=>$text[$lang],
        'reply_markup'=>$btns
    ]);


    $user->setPage(Pages::CENTERS);
}


function showOneCenter(){
    global $telegram, $user, $db, $main, $back;

    $lang = $user->getLang();
    $text = $db->getByKeyword('text', 'onecenter');

    $onecenter = $db->getAll(Pages::ONE_CENTER);
    $buttons = Buttons::buttonCreator($onecenter, 2, $lang);

    array_push($buttons, [$telegram->buildKeyboardButton($back[$lang]), $telegram->buildKeyboardButton($main[$lang])]);
    $btns = $telegram->buildKeyBoard($buttons, false, true);

    $telegram->sendMessage([
        'chat_id'=>$user->getId(),
        'text'=>$text[$lang],
        'reply_markup'=>$btns
    ]);


    $user->setPage(Pages::ONE_CENTER);
}
function showSubject(){

}
