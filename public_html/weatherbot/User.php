<?php


class User
{
    private $chatId;

    function __construct($chatId)
    {
        $this->chatId = $chatId;
        if (!is_dir("files/{$this->getId()}")){
            mkdir("files/{$this->getId()}");
        }
    }

    public function getId(){
        return $this->chatId;
    }

    public function setLang($lang){
        file_put_contents('files/'.$this->chatId.'/lang.txt', $lang);
    }

    public function getLang(){
        return file_get_contents('files/'.$this->chatId.'/lang.txt');
    }

    public function setPage($page){
        file_put_contents('files/'.$this->chatId.'/page.txt', $page);
    }

    public function getPage(){
        return file_get_contents('files/'.$this->chatId.'/page.txt');
    }

    public function setMyLocate($locate){
        file_put_contents('files/'.$this->chatId.'/mylatitude.txt', $locate['latitude']);
        file_put_contents('files/'.$this->chatId.'/mylongitude.txt', $locate['longitude']);
    }

    public function getMyLocate(){
        $latitude = file_get_contents('files/'.$this->chatId.'/mylatitude.txt');
        $longitude = file_get_contents('files/'.$this->chatId.'/mylongitude.txt');
        return ['latitude'=>$latitude, 'longitude'=>$longitude];
    }


    public function setCity($locate){
        file_put_contents('files/'.$this->chatId.'/city.txt', $locate);
    }

    public function getCity(){
        return file_get_contents('files/'.$this->chatId.'/city.txt');
    }

    public function setMessage($text){
        file_put_contents('files/'.$this->chatId.'/message.txt', $text);
    }

    public function getMessage(){
        return file_get_contents('files/'.$this->chatId.'/message.txt');
    }
}