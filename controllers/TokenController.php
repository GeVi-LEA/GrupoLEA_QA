<?php
require_once models_root.'tokens/token.php';

class tokenController {
    
    public function guardarTokenBanxico(){
       if(isset($_POST['token']) && $_POST['token'] != ""){
           $numToken = trim($_POST['token']);
  
           $token = new Token();
           $token->setToken($numToken);
           $save = $token->saveTokenBanxico();
           echo($save);       
       }
    }
    
    public function getTokenBanxico(){
           $token = new Token();
           $tokenBanxico = $token->getTokenBanxico();
           if($tokenBanxico){
            $numToken = $tokenBanxico->token;
            echo $numToken;
           }else{
             echo false;
           }
       }
    
}