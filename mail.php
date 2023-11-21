<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'classes/vendor/autoload.php';

/**
 * Description of AAEmail
 *
 * @author Juli e Marina
 */
class AAEmail {

    private $prepared = false;
    private $destinationemailaddress = null;
    private $destinationname = null;
    private $sourcemailaddress = null;
    private $sourcename = null;
    private $htmlMessage = null;
    private $altMessage = null;
    private $mailer = null;
    private $subject = null;

    public function getSubject() {
        return $this->subject;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function getDestinationemailaddress() {
        return $this->destinationemailaddress;
    }

    public function getDestinationname() {
        return $this->destinationname;
    }

    public function getSourcemailaddress() {
        return $this->sourcemailaddress;
    }

    public function getSourcename() {
        return $this->sourcename;
    }

    public function getHtmlMessage() {
        return $this->htmlMessage;
    }

    public function getAltMessage() {
        return $this->altMessage;
    }

    public function getMailer() {
        return $this->mailer;
    }

    public function setDestinationemailaddress($destinationemailaddress) {
        $this->destinationemailaddress = $destinationemailaddress;
    }

    public function setDestinationname($destinationname) {
        $this->destinationname = $destinationname;
    }

    public function setSourcemailaddress($sourcemailaddress) {
        $this->sourcemailaddress = $sourcemailaddress;
    }

    public function setSourcename($sourcename) {
        $this->sourcename = $sourcename;
    }

    public function setHtmlMessage($htmlMessage) {
        $this->htmlMessage = $htmlMessage;
    }

    public function setAltMessage($altMessage) {
        $this->altMessage = $altMessage;
    }

    public function __construct($destemail) {

        $this->mailer = new PHPMailer(true);
        $this->mailer->SMTPDebug = 2;
        $this->mailer->isSMTP();
        $this->mailer->Username = 'disciplinas.tadeu.maffeis@gmail.com';
        $this->mailer->Host = 'smtp.google.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->SMTPSecure = 'tls';
        $this->mailer->Port = /* 465 ; */ 587;
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->destinationemailaddress = $destemail;
        $this->mailer->Password = 'IAatm874150631$';
    }

    public function prepare() {
        $this->mailer->setFrom($this->sourcemailaddress, $this->sourcename);
        $this->mailer->AddReplyTo($this->sourcemailaddress, $this->sourcename);
        $this->mailer->addAddress($this->destinationemailaddress, $this->destinationname);
        $this->mailer->Subject = $this->subject;
        //
        if ($this->htmlMessage != null) {
            $this->mailer->MsgHTML($this->htmlMessage);
        }
        if ($this->altMessage == null) {
            $this->mailer->AltBody = $this->altMessage;
        }
        $this->prepared = true;
    }

    public function send() {
        $retValue = false;
        var_dump($this->mailer);
        if (!$this->prepared) {
            return $retValue;
        }

        if ($this->mailer->send()) {
            $retValue = true;
        } else {
            echo $this->mailer->ErrorInfo;
        }

        echo '<b>' . $this->mailer->ErrorInfo . '</b>';
        
        return $retValue;
    }

    public function sendEmail($dest) {


//Create a new PHPMailer instance
        $mail = new PHPMailer();
//Set who the message is to be sent from
        $mail->setFrom('aaclassroom@atmapps.pro.br', 'Tadeu');
//Set an alternative reply-to address
        $mail->addReplyTo('aaclassroom@atmapps.pro.br', 'First Last');
//Set who the message is to be sent to
        $mail->addAddress($dest, 'Tadeu');
//Set the subject line
        $mail->Subject = 'PHPMailer mail() test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        $mail->msgHTML("<html><body><b>Teste</b></body></hmtl>", __DIR__);
//Replace the plain text body with one created manually
        $mail->AltBody = 'This is a plain-text message body';
//Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors

        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message sent!';
        }
    }

    //put your code here
}


$newpassword = "AAABBB";
$mailer = new AAEmail("tadeu.maffeis@fatec.sp.gov.br");
$mailer->setSourcemailaddress("aaclassroom@atmapps.pro.br");
echo "\nName = Disciplina Estrutura de Dados";
$mailer->setSourcename("Disciplina Estrutura de Dados");
echo "\nSubject = Disciplina Estrutura de Dados - Reset Password!";
$mailer->setSubject("Disciplina Estrutura de Dados - Reset Password!");
$html = "<html><body>Código: <b>" . $newpassword . "</b><p>";
$html .= "<b>Clique no linK abaixo para resetar sua senha</b></p><p>";
$html .= "http://www.classroom.atmapps.pro.br/ED/?resetpassword";
$mailer->setHtmlMessage($html);
echo "\nhtml msg = " . $html;
$mailer->prepare();
echo "\nPrepare";

echo $mailer->sendEmail("tadeu.maffeis@fatec.sp.gov.br");



// v=spf1include:outlook.com include:spf.whservidor.com ~all

?>