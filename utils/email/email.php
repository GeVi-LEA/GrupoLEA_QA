<?php

class Mail {
    
    private $body;
    private $subject;
    private $correo1;
    private $nombre1;
    private $correos;
    private $nombres;
    private $archivo1;
    private $archivo2;
    private $ruta1;
    private $ruta2;
    
    function getBody() {
        return $this->body;
    }

    function getSubject() {
        return $this->subject;
    }

    function getCorreo1() {
        return $this->correo1;
    }

    function getNombre1() {
        return $this->nombre1;
    }

    function getCorreos() {
        return $this->correos;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getArchivo1() {
        return $this->archivo1;
    }

    function getArchivo2() {
        return $this->archivo2;
    }

    function getRuta1() {
        return $this->ruta1;
    }

    function getRuta2() {
        return $this->ruta2;
    }

    function setBody($body): void {
        $this->body = $body;
    }

    function setSubject($subject): void {
        $this->subject = $subject;
    }

    function setCorreo1($correo1): void {
        $this->correo1 = $correo1;
    }

    function setNombre1($nombre1): void {
        $this->nombre1 = $nombre1;
    }

    function setCorreos($correos): void {
        $this->correos = $correos;
    }

    function setNombres($nombres): void {
        $this->nombre2 = $nombre2;
    }

    function setArchivo1($archivo1): void {
        $this->archivo1 = $archivo1;
    }

    function setArchivo2($archivo2): void {
        $this->archivo2 = $archivo2;
    }

    function setRuta1($ruta1): void {
        $this->ruta1 = $ruta1;
    }

    function setRuta2($ruta2): void {
        $this->ruta2 = $ruta2;
    }
    
    public static function enviarMailPass($random) {
        require_once 'smtp.php';
        
        $nombre = strtok($_SESSION['usuario']->nombres, " ")." ".strtok($_SESSION['usuario']->apellidos, " ");
        $correo = $_SESSION['usuario']->correo;
 
        $mnsj = "<p>Para cambiar su password dar click en el siguiente link.</p>"
                . root_url . "?codigo=" . $random."</br></br></br>"
                ."<p><b>Nota:</b> Abrir el link en el mismo navegador en el que esta utilizando el sistema ERP.</p>"
                ."<p>No es necesario responder este correo.</p>";
        
        try {
            $mail->SetFrom('adminerp_lea@leademexico.com');
            $mail->AddAddress($correo, $nombre);
            $mail->Subject = "Correo de recuperación de password";
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->MsgHTML($mnsj);
            $mail->Send();
        } catch (phpmailerException $e) {
            echo $e->errorMessage();
            return false;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return true;
    }
    
    public static function enviarCorreoReq($mailer) {
        require_once 'smtp.php';
    
         $correo = 'adminerp_lea@leademexico.com'; 

        try {
            $mail->SetFrom($correo);
            
            foreach($mailer->getCorreos() as $correo){
            $mail->AddAddress($correo);
            }

            if($mailer->getArchivo1() != null){
             $mail->AddAttachment($mailer->getRuta1(), $mailer->getArchivo1().".pdf");
            }
             if($mailer->getArchivo2() != null){
             $mail->AddAttachment($mailer->getRuta2(), $mailer->getArchivo2()."pdf");
            }
            $mail->Subject = $mailer->getSubject();
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->MsgHTML($mailer->getBody());
            $mail->Send();
        } catch (phpmailerException $e) {
            var_dump($e->errorMessage());
            return false;
        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }
        return "true";
    }

    public static function solicitarFleteCorreo($folio, $detalle) {
        require_once 'smtp.php';
        
        $correo = 'adminerp_lea@leademexico.com'; 
 
        $mnsj = "<p>Se genero la oren de compra <b>".$folio ."</b>.</p>"
                ."<p><b>Descripción:</b> ".$detalle['descripcion']."</p>"
                ."<p><b>Cantidad producto:</b>". UtilsHelp::numero2Decimales($detalle['cantidad'])." galones.</p>";
        try {
            $mail->SetFrom($correo);
            $mail->AddAddress(compras_fletes['correo'], compras_fletes['nombre']);
            $mail->Subject = "Fletes para orden de compra: ". $folio;
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->MsgHTML($mnsj);
            $mail->Send();
        } catch (phpmailerException $e) {
            return $e->errorMessage();
            //return false;
        } catch (Exception $e) {
            return $e->getMessage();
     //       return false;
        }
        return true;
    }
    
        public static function enviarAvisoCambioPrecio($folio, $cuerpo, $detalle) {
        require_once 'smtp.php';
        
         $correo = 'adminerp_lea@leademexico.com'; 
         
         $mnsj = "<p>".$cuerpo."</p>"
                ."<p> Motivo del cambio: ".$detalle."</p>";

        try {
            $mail->SetFrom($correo);
            $mail->AddAddress(gerencia['correo'], gerencia['nombre']);
            $mail->Subject = "Cambio de precio en orden: ". $folio;
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->MsgHTML($mnsj);
            $mail->Send();
        } catch (phpmailerException $e) {
             $e->errorMessage();
           return false;
        } catch (Exception $e) {
             $e->getMessage();
          return false;
        }
        return true;
    }
    
          public static function enviarCorreoSolicitudSistemas($mailer) {
        require_once 'smtp.php';
        
         $correo = 'adminerp_lea@leademexico.com'; 
        
        try {
            $mail->SetFrom($correo);
            $mail->AddAddress($mailer->getCorreo1(), $mailer->getNombre1());
            $mail->Subject = $mailer->getSubject();
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->MsgHTML($mailer->getBody());
            $mail->Send();
        } catch (phpmailerException $e) {
             $e->errorMessage();
           return false;
        } catch (Exception $e) {
             $e->getMessage();
          return false;
        }
        return true;
    }
    
    
}
