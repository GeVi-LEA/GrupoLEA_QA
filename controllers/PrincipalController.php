<?php
class principalController{
    
    public function index(){
       header('Location:' . principalUrl . '?controller=Compras&action=index');
    }
}