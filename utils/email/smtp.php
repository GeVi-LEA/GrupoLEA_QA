<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once base.'/composer/vendor/autoload.php';
$mail = new PHPMailer(true);
// SMTP configuration
$mail->isSMTP();
$mail->Host = 'smtp.office365.com';
$mail->SMTPAuth = true;
$mail->Username = 'adminerp_lea@leademexico.com';
$mail->Password = 'Erp.lea$';
$mail->SMTPSecure = 'STARTTLS';
$mail->Port = 587;