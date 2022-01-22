<?php

function showError(){
    global $telegram, $user;

    $errorText = "👇🏼Iltimos tugmalardan birini tanlang👇🏼\n\n👇🏼Пожалуйста, выберите одну из кнопок👇🏼";
    $content  = [
        'chat_id'=>$user->getId(),
        'text'=>$errorText,
    ];

    $telegram->sendMessage($content);
}

function start(){

    global $telegram, $user, $text;
    if ($text == '/start'){
        $f_name = $telegram->FirstName();
        $username = $telegram->Username();
        $l_name = $telegram->LastName();

        if($f_name && $l_name){
            $content = ['chat_id'=>$user->getId(), 'text'=>"Assalomu alykum {$l_name} {$f_name} \nob-havo haqidagi ma'ulomtlar botiga hush kelibsiz."];
        }elseif($f_name){
            $content = ['chat_id'=>$user->getId(), 'text'=>"Assalomu alykum {$f_name} \nob-havo haqidagi ma'ulomtlar botiga hush kelibsiz."];
        }elseif($username){
            $content = ['chat_id'=>$user->getId(), 'text'=>"Assalomu alykum {$username} \nob-havo haqidagi ma'ulomtlar botiga hush kelibsiz."];
        }elseif ($l_name){
            $content = ['chat_id'=>$user->getId(), 'text'=>"Assalomu alykum {$l_name} \nob-havo haqidagi ma'ulomtlar botiga hush kelibsiz."];
        }else{
            $content = ['chat_id'=>$user->getId(), 'text'=>"Assalomu alykum ob-havo haqidagi ma'ulomtlar botiga hush kelibsiz."];
        }

        $telegram->sendMessage($content);

    }

}

function showMain(){

    global $telegram, $user;

    start();

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


function showCity(){
    global $telegram, $user, $lang;

    include_once 'language/'.$user->getLang().'.php';

    $text = $lang['texts']['city'];
    $text1 = $lang['texts']['city1'];


    $option = [];
    foreach ($lang[Pages::CITIES] as $key=>$v){
        $option[] = $telegram->buildInlineKeyboardButton($v, '', $key);
    }

    $options = array_chunk($option, 2);

    $btns = $telegram->buildInlineKeyBoard($options);


    $telegram->sendMessage([
        'chat_id'=>$user->getId(),
        'text'=>$text,
        'reply_markup'=>$btns
    ]);


    $option = array(
        array(
            $telegram->buildKeyboardButton($lang['buttons']['location'], false, true),
            $telegram->buildKeyboardButton($lang['buttons']['change'])),

        array(
            $telegram->buildKeyboardButton($lang['buttons']['offer']),
            $telegram->buildKeyboardButton($lang['buttons']['donate']))

    );
    $keyb = $telegram->buildKeyBoard($option, false, true);
    $telegram->sendMessage([
        'chat_id'=>$user->getId(),
        'text'=>$text1,
        'reply_markup'=>$keyb,
    ]);

    $user->setPage(Pages::CITIES);
}

function reverseButtons(){
    global $telegram, $user, $lang;

    $option = array(
        array($telegram->buildKeyboardButton($lang['buttons']['back']), $telegram->buildKeyboardButton($lang['buttons']['main']))
    );
    $keyb = $telegram->buildKeyBoard($option, $onetime=false, true);
    $content = array('chat_id' => $user->getId(), 'text'=>$lang['texts']['continue'], 'reply_markup' => $keyb);
    $telegram->sendMessage($content);


}

function showMyLocation(){
    global $telegram, $user, $message, $lang;

    $lat = $message['location']['latitude'];
    $lon = $message['location']['longitude'];


    $build = [
        [$telegram->buildInlineKeyboardButton($lang['buttons']['week'], '', $lang['buttons']['week']), $telegram->buildInlineKeyboardButton($lang['buttons']['month'], '', $lang['buttons']['month'])]
    ];
    $btns = $telegram->buildInlineKeyBoard($build);

    $telegram->sendMessage([
        'chat_id'=>$user->getId(),
        'text'=>weather(sendRequest('weather', ['lat'=>$lat, 'lon'=>$lon])),
        'reply_markup'=>$btns,
        'parse_mode'=>'html'
    ]);


    $user->setPage(Pages::LOCATE);
}


function showDays(){
    global $telegram, $user, $lang, $text;


    $build = [
        [
            $telegram->buildInlineKeyboardButton($lang['buttons']['week'], '', $lang['buttons']['week']),
            $telegram->buildInlineKeyboardButton($lang['buttons']['month'], '', $lang['buttons']['month'])
        ]
    ];
    $btns = $telegram->buildInlineKeyBoard($build);


    $telegram->editMessageText([
        'chat_id'=>$user->getId(),
        'message_id'=>$telegram->MessageID(),
        'text'=>weather(sendRequest('weather', ['q'=>$text])),
        'reply_markup'=>$btns,
        'parse_mode'=>'html'
    ]);

    $user->setPage(Pages::LOCATE);
}

function showWeek(){

}

function showMonth(){

}


function donate(){ 
    global $telegram, $user, $lang;

    $content = array('chat_id' => $user->getId(), 'text'=>$lang['texts']['money']);
    $telegram->sendMessage($content);

    $option = array(
        array($telegram->buildKeyboardButton($lang['buttons']['back']), $telegram->buildKeyboardButton($lang['buttons']['main'])),

    );
    $keyb = $telegram->buildKeyBoard($option, $onetime=false, true);
    $content = array('chat_id' => $user->getId(), 'text'=>$lang['texts']['plastik'], 'reply_markup' => $keyb);
    $telegram->sendMessage($content);
    $user->setPage(Pages::DONATE);
}

function sendAdmin(){
    global $telegram, $user, $lang;

    $content = array('chat_id' => $user->getId(), 'text'=>$lang['texts']['offer']);
    $telegram->sendMessage($content);

    $option = array(
        array($telegram->buildKeyboardButton($lang['buttons']['send']), $telegram->buildKeyboardButton($lang['buttons']['cancel'])),
        array($telegram->buildKeyboardButton($lang['buttons']['back']), $telegram->buildKeyboardButton($lang['buttons']['main'])),

    );
    $keyb = $telegram->buildKeyBoard($option, $onetime=false, true);
    $content = array('chat_id' => $user->getId(), 'text'=>$lang['texts']['text'], 'reply_markup' => $keyb);
    $telegram->sendMessage($content);
    $user->setPage(Pages::ADMIN);
}

function textTest(){
    global $telegram, $user, $lang;
    $matn = strtolower($user->getMessage());
    $texts = explode(' ', $matn);
    $bool = false;
    $danger = ['dumbul', 'kalla', 'kallanga', 'kotinga', 'kot', "ko't", "ko'tinga", "qo'lim", "qolim", "bel", "ot", "fil", "eshak", "it"];
    foreach ($danger as $key => $v){
        if (in_array($v, $texts)){
            $bool = true;
        }
    }
    if($bool){
        $matn = "Xabarni tasdiqlash orqali siz 🚷spamga🚷 tushasiz! Nomaqbul so'zlar mavjud🚫 Bekor qilish yoki boshqa tugmani bosing 👇🏼";
    }else{
        $matn = "
        Xabaringiz jo'natilishga tayyor ✅
        Xabarni tasdiqlash tugamasini bosing 👇🏼
        ";
    }

    $content = array('chat_id' => $user->getId(), 'text'=>$matn);
    $telegram->sendMessage($content);

}

function showMessageInfo(){
    global $telegram, $user;

    $errorText = "Xabar jo'natildi ✅";
    $content  = [
        'chat_id'=>$user->getId(),
        'text'=>$errorText,
    ];

    $telegram->sendMessage($content);

    $errorText = "Taklif va maslahatlaringiz uchun rahmat tez orada admin javob qaytaradi";
    $content  = [
        'chat_id'=>$user->getId(),
        'text'=>$errorText,
    ];

    $telegram->sendMessage($content);


    $errorText = "Botdan foydalanishda davom eting 👍🏼";
    $content  = [
        'chat_id'=>$user->getId(),
        'text'=>$errorText,
    ];

    $telegram->sendMessage($content);

    $telegram->UserID();
    $telegram->sendMessage([
        'chat_id'=>949938784,
        'text'=>$user->getMessage(),
    ]);

}


function showCancel(){
    global $telegram, $user;

    $errorText = "Xabar bekor qilindi ❎";
    $content  = [
        'chat_id'=>$user->getId(),
        'text'=>$errorText,
    ];

    $telegram->sendMessage($content);

    $errorText = "Yangi xabar kiriting yoki ortga qayting";
    $content  = [
        'chat_id'=>$user->getId(),
        'text'=>$errorText,
    ];

    $telegram->sendMessage($content);
}