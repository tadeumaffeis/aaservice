<?php


/* apenas dispara o envio do formulário caso exista $_POST['enviarFormulario']*/


if (isset($_POST['enviarFormulario'])){


/*** INÍCIO - DADOS A SEREM ALTERADOS DE ACORDO COM SUAS CONFIGURAÇÕES DE E-MAIL ***/


$enviaFormularioParaNome = 'Antonio Tadeu Maffeis';

$enviaFormularioParaEmail = 'tadeu.maffeis@gmail.com';


$caixaPostalServidorNome = 'WebSite | Formulário';

$caixaPostalServidorEmail = 'aaclassroom@atmapps.pro.br';

$caixaPostalServidorSenha = 'ia847atm';


/*** FIM - DADOS A SEREM ALTERADOS DE ACORDO COM SUAS CONFIGURAÇÕES DE E-MAIL ***/


/* abaixo as variaveis principais, que devem conter em seu formulario*/


$remetenteNome  = $_POST['remetenteNome'];

$remetenteEmail = $_POST['remetenteEmail'];

$assunto  = $_POST['assunto'];

$mensagem = $_POST['mensagem'];


$mensagemConcatenada = 'Formulário gerado via website'.'<br/>';

$mensagemConcatenada .= '-------------------------------<br/><br/>';

$mensagemConcatenada .= 'Nome: '.$remetenteNome.'<br/>';

$mensagemConcatenada .= 'E-mail: '.$remetenteEmail.'<br/>';

$mensagemConcatenada .= 'Assunto: '.$assunto.'<br/>';

$mensagemConcatenada .= '-------------------------------<br/><br/>';

$mensagemConcatenada .= 'Mensagem: "'.$mensagem.'"<br/>';

/*********************************** A PARTIR DAQUI NAO ALTERAR ************************************/


require ('classes/phpmailer/class.phpmailer.php');

$mail = new PHPMailer();

$mail->SMTPDebug = 2;

$mail->IsSMTP();

$mail->SMTPAuth  = true;

$mail->Charset   = 'utf8_decode()';

$mail->Host  = 'smtp.'.substr(strstr($caixaPostalServidorEmail, '@'), 1);

$mail->Port  = '587';

$mail->Username  = $caixaPostalServidorEmail;

$mail->Password  = $caixaPostalServidorSenha;

$mail->From  = $caixaPostalServidorEmail;

$mail->FromName  = utf8_decode($caixaPostalServidorNome);

$mail->IsHTML(true);

$mail->Subject  = utf8_decode($assunto);

$mail->Body  = utf8_decode($mensagemConcatenada);


$mail->AddAddress($enviaFormularioParaEmail,utf8_decode($enviaFormularioParaNome));


if(!$mail->Send()){

$mensagemRetorno = 'Erro ao enviar formulário: '. print($mail->ErrorInfo);

}else{

$mensagemRetorno = 'Formulário enviado com sucesso!';

}

}

?>


<html lang="pt-BR">


<head>

    <meta charset="utf-8">

<title>Formulário Exemplo Autenticado</title>

</head>

<body>


<?php

if(isset($mensagemRetorno)){

echo $mensagemRetorno;

}


?>

<form method="POST" action="" style="width:300px;">

<input type="text" name="remetenteNome" placeholder="Nome completo" style="float:left;margin:10px;">

<input type="text" name="remetenteEmail" placeholder="Email" style="float:left;margin:10px;">

<input type="text" name="assunto" placeholder="Assunto" style="float:left;margin:10px;">

<textarea name="mensagem" placeholder="Mensagem" style="float:left;margin:10px;height:100px;width:200px;"></textarea>

<input type="submit" value="enviar" name="enviarFormulario" style="float:left;margin:10px;">

</form>


</body>

</html>

