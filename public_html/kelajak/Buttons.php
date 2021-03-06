<?php


class Buttons{

    const BTN_UZ = '๐บ๐ฟ O\'zbek tili ๐บ๐ฟ';
    const BTN_RU = '๐ท๐บ Pัััะบะธะน ๐ท๐บ';
    const BTN_CHANGE_UZ = '๐ Tilni o\'zgartirish ๐';
    const BTN_CHANGE_RU = '๐ ะะทะผะตะฝะธัั ัะทัะบ ๐';

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