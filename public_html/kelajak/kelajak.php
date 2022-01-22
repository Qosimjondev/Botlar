<?php
require_once 'load.php';
/**@var  $user User */
/**@var $telegram Telegram */
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
                showOneCenter();
            }elseif ($text == Buttons::BTN_RU){
                $user->setLang(User::RU);
                showOneCenter();
            }else{
                showError();
            }
            break;
        case Pages::ONE_CENTER:
            switch ($text){
                case Buttons::BTN_CHANGE_UZ:
                case Buttons::BTN_CHANGE_RU:
                    showMain();
                    break;
                default:
                    if (in_array($text, $db->getAll(Pages::ONE_CENTER, $user->getLang()))){
                        switch ($text){
                            case $db->getByKeyword('onecenter', 'courses')[$user->getLang()]:
                                showCourses();
                                break;
                            case $db->getByKeyword('onecenter', 'teachers')[$user->getLang()]:
                                showTeachers();
                                break;
                            case $db->getByKeyword('onecenter', 'results')[$user->getLang()]:
                                showResults();
                                break;
                            case $db->getByKeyword('onecenter', 'application')[$user->getLang()]:
                                showApplication();
                                break;
                            case $db->getByKeyword('onecenter', 'Phone')[$user->getLang()]:
                                showPhone();
                                break;
                            case $db->getByKeyword('onecenter', 'exam')[$user->getLang()]:
                                showExam();
                                break;
                            case $db->getByKeyword('onecenter', 'location')[$user->getLang()]:
                                showLocation();
                                break;
                        }
                    }else{
                        showError();
                    }
                    break;
            }
            break;
        case Pages::LOCATION:
            switch ($text){
                case $back[$user->getLang()]:
                    showOneCenter();
                    break;
                case $main[$user->getLang()]:
                    showMain();
                    break;
                default:
                    showError();
                    break;
            }

        case Pages::PHONE:
            switch ($text){
                case $back[$user->getLang()]:
                    showOneCenter();
                    break;
                case $main[$user->getLang()]:
                    showMain();
                    break;
                default:
                    showError();
                    break;
            }

    }
}
