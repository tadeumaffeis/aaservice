<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Carregue as classes do PHPMailer usando o autoloader do Composer
require 'classes/vendor/autoload.php';

// Crie uma nova instância do PHPMailer
$mail = new PHPMailer(true);

try {
    // Configurações do servidor de e-mail
    $mail->isSMTP();
    //$mail->IsSendmail();
    $mail->Host = 'smtp.atmapps.pro.br';
    $mail->Port = 587; 			// A porta SMTP pode variar (587 é comum para TLS)
    //$mail->SMTPSecure = 'tls'; 	// Use 'tls' ou 'ssl' conforme necessário
    //$mail->SMTPAuth = true;
    $mail->Username = 'aaclassroom@atmapps.pro.br';
    $mail->Password = '@IA847atm';

    // Configurações adicionais (opcional)
    $mail->setFrom('aaclassroom@atmapps.pro.br', 'AACLassroom');
    $mail->addAddress('tadeu.maffeis@gmail.com', 'Tadeu');
    $mail->Subject = 'Teste';
    $mail->Body = 'Conteúdo do E-mail';

    // Enviar e-mail
    $mail->send();
    echo 'E-mail enviado com sucesso!';
} catch (Exception $e) {
    //echo 'Erro ao enviar e-mail: ' . $mail->ErrorInfo;
    var_dump($ex);
}
?>

// v=spf1include:outlook.com include:spf.whservidor.com ~all
