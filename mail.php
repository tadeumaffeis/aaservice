<?php
$headers = 'Content-Type: text/plain; charset=utf-8' . "\r\n";
$headers .= 'Content-Transfer-Encoding: base64' . "\r\n";
$subject = '=?UTF-8?B?' . base64_encode('Test email with German Umlauts öäüß') . '?=';
$recipient = '=?UTF-8?B?' . base64_encode('Margret Müller') . '?= <tadeu.maffeis@gmail.com>';

$message = base64_encode('This email contains German Umlauts öäüß.');
$success = mail('tadeu.maffeis@fatec.sp.gov.br', 'My Subject', $message);
if (!$success) {
    $errorMessage = error_get_last()['message'];
}

echo '<b>' . $errorMessage . '<b> message!';
?>