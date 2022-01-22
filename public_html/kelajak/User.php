<?php


class User
{
    private $chatId;
    const UZ = 'uz';
    const RU = 'ru';

    function __construct($chatId)
    {
        $this->chatId = $chatId;
    }

    public function getId(){
        return $this->chatId;
    }

    public function setLang($lang){
        file_put_contents('files/'.$this->chatId.'lang.txt', $lang);
    }

    public function getLang(){
        return file_get_contents('files/'.$this->chatId.'lang.txt');
    }

    public function setPage($page){
        file_put_contents('files/'.$this->chatId.'page.txt', $page);
    }

    public function getPage(){
        return file_get_contents('files/'.$this->chatId.'page.txt');
    }

}