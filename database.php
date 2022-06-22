<?php
class Database {
    public $host = DB_HOST;
    public $user = DB_USER;
    public $pass = DB_PASS;
    public $db_name = DB_NAME;

    public $link;
    public $error;

    function __construct() {
        $this->db_connect();
    }
    public function db_connect()
    {
        $this->link = new mysqli($this->host,$this->user,$this->pass,$this->db_name);
        if(!$this->link){
            $this->error = 'Connection error'.$this->link->connect_error;
            return false;
        }
    }

    // insert img 
    public function imgInsert($query)
    {
        $insert_row = $this->link->query($query) or die($this->link->error.__LINE__);
        if($insert_row) {
            header('Location: index.php');
            exit();
        }
        else{
            die('Image not inserted'.$this->link->error);
        }
    }
    // insert img 

    // select img 
    public function select($query)
    {
        $select_row = $this->link->query($query) or die($this->link->error.__LINE__);
        if($select_row->num_rows>0)
        {
            return $select_row;
        }
        else{
            return false;
        }
    }
    // select img 
}
?>