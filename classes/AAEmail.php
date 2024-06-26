<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

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
    private $mail = null;
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
        return $this->mail;
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
        $this->mail->msgHTML($htmlMessage, __DIR__);
    }

    public function setAltMessage($altMessage) {
        $this->altMessage = $altMessage;
    }

    public function addAddress($dest, $name = "Anonymous") {
        $this->mail->addAddress($dest, $name);
    }

    public function __construct($destemail) {

        $this->mail                 = new PHPMailer(true);
        //$this->mail->SMTPDebug      = 2;
        $this->mail->Host           = 'smtp.atmapps.pro.br';
        $this->mail->Username       = 'aaclassroom@atmapps.pro.br';
        $this->mail->Password       = '@IA847atm';
        $this->mail->isSMTP();
        $this->mail->SMTPAuth       = true;
        //$this->mail->SMTPSecure   = 'tls';
        $this->mail->Port           = 587;
        $this->mail->IsHTML(true);
        //$this->mail->SMTPSecure   = PHPMailer::ENCRYPTION_SMTPS;
        $this->mail->CharSet        = 'UTF-8';
        $this->mail->setFrom('aaclassroom@atmapps.pro.br', '[AAClassroom] Alteração de senha');
        $this->mail->addReplyTo('aaclassroom@atmapps.pro.br', '[AAClassroom] Alteração de senha');
        $this->mail->Subject = 'Recuperação de Senha AAClassroom';
        $this->addAddress($destemail);
        /*
          $this->mail = new PHPMailer(true);
          $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
          $this->mail->isSMTP();
          $this->mail->Username = 'disciplinas.tadeu.maffeis@gmail.com';
          $this->mail->Host = 'smtp.google.com';
          $this->mail->SMTPAuth = true;
          //$this->mail->SMTPSecure = 'tls';
          $this->mail->Port = 465 ;  587;
          $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
          $this->destinationemailaddress = $destemail;
          $this->mail->Password = 'IAatm874150631$';
         */
    }

    public function prepare() {
        //$this->mail->setFrom($this->sourcemailaddress, $this->sourcename);
        //$this->mail->AddReplyTo($this->sourcemailaddress, $this->sourcename);
        //$this->mail->addAddress($this->destinationemailaddress, $this->destinationname);
        //$this->mail->Subject = $this->subject;
        //
        if ($this->htmlMessage != null) {
            $this->mail->MsgHTML($this->htmlMessage);
        }
        if ($this->altMessage == null) {
            $this->mail->AltBody = $this->altMessage;
        }
        $this->prepared = true;
    }

    public function send() {
        $retValue = false;
        if (!$this->prepared) {
            return $retValue;
        }

        if ($this->mail->send()) {
            $retValue = true;
        } 

        return $retValue;
    }

}

/*
$newpassword = "AAABBB";
$mail = new AAEmail("tadeu.maffeis@fatec.sp.gov.br");
$mail->setSourcemailaddress("ed.ads.fitu@atmapps.pro.br");
echo "\nName = Disciplina Estrutura de Dados";
$mail->setSourcename("Disciplina Estrutura de Dados");
echo "\nSubject = Disciplina Estrutura de Dados - Reset Password!";
$mail->setSubject("Disciplina Estrutura de Dados - Reset Password!");
$html = "<html><body>Código: <b>" . $newpassword . "</b><p>";
$html .= "<b>Clique no linK abaixo para resetar sua senha</b></p><p>";
$html .= "http://www.classroom.atmapps.pro.br/ED/?resetpassword";
$mail->setHtmlMessage($html);
echo "\nhtml msg = " . $html;
$mail->prepare();
echo "\nPrepare";

echo $mail->send();

 */