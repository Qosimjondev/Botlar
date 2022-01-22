<?php
require_once 'load.php';
/**@var  $user User */
/**@var $text Telegram */
/** @var $db DbConnect */
/** @var $back DbConnect */
/** @var $main DbConnect */
/** @var $districts DbConnect */



if ($text == '/start'){
    showMain();
}else{
    switch ($user->getPage()){
        case Pages::START:
            if ($text == Buttons::BTN_UZ){
                $user->setLang(User::UZ);
                showDistrict();
            }elseif ($text == Buttons::BTN_RU){
                $user->setLang(User::RU);
                showDistrict();
            }else{
                showError();
            }
            break;

        case Pages::DISTRICTS:
            switch ($text){
                case Buttons::BTN_CHANGE_UZ:
                case Buttons::BTN_CHANGE_RU:
                    showMain();
                    break;
                default:
                    if (in_array($text, $districts)){
                        $user->setDistrict($text);
                        showCenters();
                    }
                    else{
                        showError();
                }
                    break;
            }
            break;
        case Pages::CENTERS:
            switch ($text){
                case $back[$user->getLang()]:
                    showDistrict();
                    break;
                case $main[$user->getLang()]:
                    showMain();
                    break;
                default:
                    if (in_array($text, $db->getAll(Pages::CENTERS, 'uz'))){
                        $user->setCenter($text);
                        showOneCenter();
                    }else{
                        showError();
                    }
                    break;
            }
            break;
        case Pages::ONE_CENTER:
            switch ($text){
                case $back[$user->getLang()]:
                    showCenters();
                    break;
                case $main[$user->getLang()]:
                    showMain();
                    break;
                default:
                    if (in_array($text, $db->getAll(Pages::ONE_CENTER, 'uz'))){
                        $user->setOneCenter($text);
                        showOneCenter();
                    }else{
                        showError();
                    }
                    break;
            }
            break;
    }
}
