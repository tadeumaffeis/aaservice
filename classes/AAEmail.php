<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

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
        $this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mailer->isSMTP();
        $this->mailer->Username = 'aaclassroom@atmapps.pro.br';
        $this->mailer->Host = 'smtp.atmapps.pro.br';
        $this->mailer->SMTPAuth = true;
        //$this->mailer->SMTPSecure = 'tls';
        $this->mailer->Port = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->destinationemailaddress = $destemail;
        $this->mailer->Password = '@IA847atm';
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

        return $retValue;
    }

    //put your code here
}

/*
$newpassword = "AAABBB";
$mailer = new AAEmail("tadeu.maffeis@fatec.sp.gov.br");
$mailer->setSourcemailaddress("ed.ads.fitu@atmapps.pro.br");
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

echo $mailer->send();

 */