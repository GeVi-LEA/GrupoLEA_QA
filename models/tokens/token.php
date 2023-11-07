<?php

class Token {
    private $id;
    private $identidad;
    private $token;
    private $descripcion;
    private $db;

   public function __construct() {
      $this->db = Database::connect();
    } 
    
    function getId() {
        return $this->id;
    }

    function getIdentidad() {
        return $this->identidad;
    }

    function getToken() {
        return $this->token;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setIdentidad($identidad): void {
        $this->identidad = $identidad;
    }

    function setToken($token): void {
        $this->token = $token;
    }

    function setDescripcion($descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function saveTokenBanxico(){
       $token = $this->getTokenBanxico();
       if($token){
         $sql = "update token_tokens set token = '{$this->getToken()}' where id = '{$token->id}'";
       }else{
         $id = $this->getIdUltimoToken() + 1;
         $sql = "insert into token_tokens values({$id}, 'Banxico', '{$this->getToken()}' ,'Token para tipo de cambio Banxico')";  
       }
      $save = $this->db->query($sql);
            $result = false;
        if ($save) {
                $result = true;
        }else{
           $result = false;
        }
        return $result;
   }
   
    public function getTokenBanxico(){
       $sql = "select * from token_tokens where entidad = 'Banxico'";
       $token = $this->db->query($sql);
       if($token-> num_rows == 1){
         return $token->fetch_object();
      }else{
         return false;
      }
       
   }
   
        public function getIdUltimoToken(){
        $sql = "SELECT MAX(id)as id FROM token_tokens";
        $query = $this->db->query($sql);
        $id = $query->fetch_object()->id;
        return $id;
   }
}