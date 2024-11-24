<?php 

use PHPMailer\PHPMailer\PHPMailer;


function enviar_email ($destinatario, $assunto, $mensagem){

    require '../vendor/autoload.php';

$mail = new PHPMailer;

$mail->isSMTP(); // Corrigido de isSMTO() para isSMTP()
$mail->SMTPDebug = 2; // Corrigido de SMTPDenug para SMTPDebug
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->Username = 'britacalteste@gmail.com';
$mail->Password = 'd s d u x t j f h om w u f d c';
$mail->SMTPSecure = 'ssl'; // Corrigido de false para 'ssl'

$mail->isHTML(true);
$mail->CharSet = 'UTF-8';

$mail->setFrom('britacalteste@gmail.com', "Teste Britacal");

$mail->addAddress($destinatario);
$mail->Subject =  $assunto;

$mail->Body = $mensagem; 

if ($mail->send()) {
    echo "E-mail enviado.";
} else {
    echo "Falha ao enviar: " . $mail->ErrorInfo; 
}

}

?>
