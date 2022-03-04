<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->CharSet    = "UTF-8";
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = '34johnnydang@gmail.com';
$mail->Password   = '1@3$qwer';
$mail->SMTPSecure = 'tls';
$mail->Port       = 587;
$mail->setFrom('34johnnydang@gmail.com', 'Đăng và những người bạn');
$mail->isHTML(true);
