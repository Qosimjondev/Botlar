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

    public function setDistrict($district){
        file_put_contents('files/'.$this->chatId.'district.txt', $district);
    }

    public function getDistrict(){
        return file_get_contents('files/'.$this->chatId.'district.txt');
    }

    public function setCenter($center){
        file_put_contents('files/'.$this->chatId.'center.txt', $center);
    }

    public function getCenter(){
        return file_get_contents('files/'.$this->chatId.'center.txt');
    }

    public function setOneCenter($center){
        file_put_contents('files/'.$this->chatId.'onecenter.txt', $center);
    }

    public function getOneCenter(){
        return file_get_contents('files/'.$this->chatId.'onecenter.txt');
    }

    public function setSubject($subjetc){
        file_put_contents('files/'.$this->chatId.'subject.txt', $subjetc);
    }

    public function getSubject(){
        return file_get_contents('files/'.$this->chatId.'subject.txt');
    }

}