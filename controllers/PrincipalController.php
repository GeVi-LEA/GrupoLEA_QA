<?php
class principalController{
    
    public function index(){
       header('Location:' . principalUrl . '?controller=Home&action=index');
    }
}