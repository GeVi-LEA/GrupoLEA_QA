<?php
class homeController
{
    public function index()
    {
        Utils::noLoggin();
        require_once views_root . 'home/index.php';
    }

    public function home()
    {
        Utils::noLoggin();
        require_once views_root . 'master/home.php';
    }
}