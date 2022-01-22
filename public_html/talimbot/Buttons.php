<?php


class Buttons{

    const BTN_UZ = 'O\'zbek tili 🇺🇿';
    const BTN_RU = 'Pусский 🇷🇺';
    const BTN_CHANGE_UZ = 'Tilni o\'zgartirish';
    const BTN_CHANGE_RU = 'Изменить язык';

    public static function buttonCreator($btns=null, $range=1, $lang){
        global $telegram;
        $option = [];

        foreach ($btns as $btn){
                $option[] = $telegram->buildKeyboardButton($btn[$lang]);
        }
        if ($range == 2){
            return  array_chunk($option, 2);
        }elseif ($range == 3){
            return array_chunk($option, 3);
        }elseif ($range == 4){
            return array_chunk($option, 4);
        }else{
            return array_chunk($option, 1);
        }
    return null;
    }
}


?>