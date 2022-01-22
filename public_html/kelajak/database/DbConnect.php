<?php


class DbConnect{
    protected $host;
    protected $user;
    protected $pass;
    protected $dbname;
    public $db;


    function __construct($hostname, $username, $password, $databasename)
    {
        $this->host = $hostname;
        $this->user = $username;
        $this->pass = $password;
        $this->dbname = $databasename;
        $this->db = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->db->connect_errno){
            return 'Ulanishdagi hatolik '.$this->db->connect_error;
        }
        $this->db->set_charset('utf8mb4');
        return $this->db;
    }

    public function getAll($tbname, $lang=null){
        if($lang == null){
            $query = "SELECT *FROM $tbname";
            $res = $this->db->query($query);
            $m = [];
            while ($r = $res->fetch_assoc()){
                $m[] = $r;
            }
            if (count($m)>0){
                return $m;
            }
        }else{
            $query = "SELECT *FROM $tbname";
            $res = $this->db->query($query);
            $m = [];
            while ($r = $res->fetch_assoc()){
                $m[] = $r[$lang];
            }
            if (count($m)>0){
                return $m;
            }
        }

        return null;
    }

    public function getByKeyword($tbname, $keyword){
        $query = "SELECT *FROM $tbname WHERE keyword='{$keyword}' LIMIT 1";
        $res = $this->db->query($query);
        return $res->fetch_assoc();
    }

    public function getAnyOneKeyword($tbname, $column, $keyword){
        $query = "SELECT *FROM $tbname WHERE $column='{$keyword}' LIMIT 1";
        $res = $this->db->query($query);
        return $res->fetch_assoc();
    }

    public function getAnyAllKeyword($tbname, $column, $keyword){
        $query = "SELECT *FROM $tbname WHERE $column='{$keyword}'";
        $res = $this->db->query($query);
        $m = [];
        while ($r = $res->fetch_assoc()){
            $m[] = $r;
        }
        if (count($m)>0){
            return $m;
        }
        return [];
    }

    public function getById($tbname, $id){

    }



}

$db = new DbConnect('localhost', 'kelajak4_qosimjon', 'M5o%WyFMN+Cs', 'kelajak4_learn');


?>