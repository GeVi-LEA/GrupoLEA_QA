<?php

require_once models_root .'catalogos/usuario.php';
require_once utils_root .'email/email.php';

class loginController {

    public function index() {
      if(isset($_SESSION['usuario'])){
            if($_SESSION['usuario']!=""){
                  header('Location:' . principalUrl . '?controller=Principal&action=index');
            }else{
                  require_once views_root .'login/login.php';
            }
      }
      else{
            require_once views_root .'login/login.php';
      }
    }

    public function login() {

        if (isset($_POST['user']) && $_POST['user'] != "" && isset($_POST['password']) && $_POST['password']) {
            $user = trim($_POST['user']);
            $pass = trim($_POST['password']);

            $usuario = new Usuario();
            $result = $usuario->getByUser($user);

            if ($result && $result->num_rows == 1) {
                $userLog = $result->fetch_object();
                $_SESSION['usuario'] = $userLog;
                $verify = password_verify($pass, $userLog->password);

                if ($verify) {
                    header('Location:' . principalUrl . '?controller=Principal&action=index');
                } else {
                    $_SESSION['error']['password'] = "Contraseña incorrecta";
                    header("Location:" . root_url);
                }
            } else {
                $_SESSION['error']['usuario'] = "Usuario no existe";
                header("Location:" . root_url);
            }
        }
    }

    public function correoRecupera() {
        $random = rand(500000, 10000000000);
        $_SESSION['random'] = $random;
        $result = Mail::enviarMailPass($random);
        if ($result) {
            $_SESSION['ok']['envioCorreo'] = "Se envío correo de recuperación, revise su bandeja de correo.";
        } else {
            $_SESSION['error']['envioCorreo'] = "No se logro enviar el correo, algo salio mal.";
        }
        header("Location:" . root_url);
    }

    public function recuperarPass() {

        if (isset($_POST['user']) && $_POST['user'] != "" && isset($_POST['password']) && $_POST['password']) {
            $user = trim($_POST['user']);
            $pass = trim($_POST['password']);
            $get = intval(trim($_POST['get']));
            $verify = ($get == $_SESSION['random']) ? true : false;
            if (!$verify) {
                $_SESSION['error']['codigo'] = "Codigo no coincide, intente enviar un nuevo correo de recuperación.";
                header("Location:" . root_url);
            } else {
                $usuario = new Usuario();
                $usuario->setUser($user);
                $usuario->setPassword($pass);
                $result = $usuario->updatePass();

                if ($result) {
                    $_SESSION['ok']['updatePass'] = "Se cambio el password correctamente";
                } else {
                    $_SESSION['error']['updatePass'] = "No se logro cambiar el password, algo salio mal";
                }
                header("Location:" . root_url);
            }
            Utils::deleteSession('random');
        }
    }

    public function logOut(){
        Utils::deleteSession('usuario');
            header("Location:" . root_url);
    }
}