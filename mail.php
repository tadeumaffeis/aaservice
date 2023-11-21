<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

require_once 'classes/phpmailer/class.phpmailer.php';

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

    public function setMailer($mailer) {
        $this->mailer = $mailer;
    }

    public function __construct($destemail) {

	try {
        	$this->mailer = new PHPMailer();
	} catch (Exception $ex) {
		var_dump($ex);
        }
	$this->mailer->SMTPDebug = 2;
        $this->destinationemailaddress = $destemail;
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
        if (!$this->prepared) {
            return $retValue;
        }

        $this->mailer->SMTPDebug = 2;

        if ($this->mailer->send()) {
            $retValue = true;
        }

        return $retValue;
    }

    //put your code here
}



$newpassword = "AAABBB";
$mailer = new AAEmail("tadeu.maffeis@fatec.sp.gov.br");
$mailer->setSourcemailaddress("aaclassroom@atmapps.pro.br");
echo "\nName = Disciplina Estrutura de Dados<p>";
$mailer->setSourcename("Disciplina Estrutura de Dados");
echo "\nSubject = Disciplina Estrutura de Dados - Reset Password!<p>";
$mailer->setSubject("Disciplina Estrutura de Dados - Reset Password!");
$html = "<html><body>Código: <b>" . $newpassword . "</b><p>";
$html .= "<b>Clique no linK abaixo para resetar sua senha</b></p><p>";
$html .= "http://www.classroom.atmapps.pro.br/ED/?resetpassword";
$mailer->setHtmlMessage($html);
echo "\nhtml msg = " . $html . "<p>";
$mailer->prepare();
echo "\nPrepare <p>";

echo $mailer->send();

