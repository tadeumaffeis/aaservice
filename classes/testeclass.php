<?php

require_once 'phpmailer/class.phpmailer.php';

// Nome da classe que você quer verificar
$nomeDaClasse = 'PHPMailer';

// Testar se a classe existe
if (class_exists($nomeDaClasse)) {
    echo "A classe $nomeDaClasse existe!";
} else {
    echo "A classe $nomeDaClasse não existe.";
}
