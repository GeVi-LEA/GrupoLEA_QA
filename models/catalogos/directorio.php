<?php

class Directorio {
    
    private $db;

    public function __construct() {
     $this->db = Database::connect();
    }
    
    public function getAll() {
     $result = array();
     $sql = "select * from view_directorio";
     $directorio = $this->db->query($sql);
       while ($d = $directorio->fetch_object()) {
         array_push($result, $d);
       }
    return $result;
        
    }
}
