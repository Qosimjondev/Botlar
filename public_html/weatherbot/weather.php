<?php
/** @var $lang [] */
/** @var $user User */

require_once 'load.php';




if ($text == '/start'){
    showMain();
}else {
    switch ($user->getPage()) {
        case Pages::START:
            if ($text == Buttons::BTN_UZ) {
                $user->setLang('uz');
                showCity();
            } elseif ($text == Buttons::BTN_RU) {
                $user->setLang('ru');
                showCity();
            } else {
                showError();
            }
            break;

        case Pages::CITIES:
            switch ($text) {
                case $lang['buttons']['change']:
                    showMain();
                    break;
                default:
                    if (array_key_exists($text, $lang[Pages::CITIES])) {
                        $user->setCity($text);
                        showDays();
                        reverseButtons();

                    } elseif($message['location']) {
                        $user->setMyLocate($message['location']);
                        showMyLocation();
                        reverseButtons();

                    }elseif ($text == $lang['buttons']['offer']){
                        sendAdmin();
                    }elseif ($text == $lang['buttons']['donate']){
                        donate();
                    } else {
                        showError();
                    }
                    break;

            }
            break;
        case Pages::LOCATE:
            switch ($text){
                case $lang['buttons']['back']:
                    showCity();
                    break;
                case $lang['buttons']['main']:
                    showMain();
                    break;
                case $lang['buttons']['week']:
                    showWeek();
                    break;
                case $lang['buttons']['month']:
                    showMonth();
                    break;
                default:
                    showError();
                    break;
            }
            break;
        case Pages::DONATE:
            if ($text == $lang['buttons']['back']) {
                showCity();
            } elseif ($text == $lang['buttons']['main']) {
                showMain();
            } else {
                showError();
            }
            break;

        case Pages::ADMIN:
            switch ($text){
                case $text == $lang['buttons']['back']:
                    showCity();
                    break;
                case $lang['buttons']['main']:
                    showMain();
                    break;
                case $lang['buttons']['send']:
                    showMessageInfo();
                    break;
                case $lang['buttons']['cancel']:
                    showCancel();
                    break;
                default:
                    $user->setMessage($text);
                    textTest();
                    break;
            }
    }

}