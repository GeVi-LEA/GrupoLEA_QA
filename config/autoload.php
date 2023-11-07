<?php

function controllers_autoload($classname){
    include controller_root.$classname.'.php';
}

spl_autoload_register('controllers_autoload');