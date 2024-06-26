<?php

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

require_once 'classes/ReturnMessage.php';
require_once 'classes/Login.php';
require_once 'classes/LoginUser.php';
require_once 'classes/AAEmail.php';
require_once 'classes/database/AASqlTransactionGetStudentClassAssignment.php';

header('content-type: application/json; charset=utf-8');

//header('Content-Type: text/html; charset=utf-8');
//if (!filter_has_var(INPUT_SERVER, 'DOCUMENT_ROOT')) {
//    $jsonObj = new ReturnMessage(405, 'No root directory defined');
//    echo $jsonObj->toJSON();
//    return;
//}
//$db_path = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . "\database\AADB.sqlite";
$db_path = null;

//$conn = AAConnectDB::getConnection($db_path);

if (!filter_has_var(INPUT_SERVER, 'QUERY_STRING')) {
    $jsonObj = new ReturnMessage(404, 'No method defined');
    echo $jsonObj->toJSON();
    return;
}

switch (filter_input(INPUT_SERVER, 'QUERY_STRING')) {
    case "login" : {
            if (!filter_has_var(INPUT_POST, 'json')) {
                $jsonObj = new ReturnMessage(400, 'No login information');
                echo $jsonObj->toJSON();
                die();
            }
            $json_received = base64_decode(filter_input(INPUT_POST, 'json'));
            $json_array = json_decode($json_received, true);
            $login = new Login($json_array['username'], $json_array['passwordHash']);
            if ($login->isValid()) {
                $loginUser = new LoginUser($json_array['username'], null, $db_path);
                if (!$loginUser->existTempPassword()) {
                    $jsonObj = new ReturnMessage(200, 'Valid login name');
                } else {
                    $jsonObj = new ReturnMessage(400, 'Exists temp password setted');
                }
            } else {
                $jsonObj = new ReturnMessage(400, 'Invalid login');
            }
            echo $jsonObj->toJSON();
            break;
        }
    case "createloginuser" : {
            if (!filter_has_var(INPUT_POST, 'json')) {
                $jsonObj = new ReturnMessage(400, 'No login information');
                echo $jsonObj->toJSON();
                die();
            }
            $json_received = base64_decode(filter_input(INPUT_POST, 'json'));
            $json_array = json_decode($json_received, true);
            $loginUser = new LoginUser($json_array['username'], $json_array['passwordHash']);
            if ($loginUser->create()) {
                $jsonObj = new ReturnMessage(200, 'Login user created with sucess');
            } else {
                $jsonObj = new ReturnMessage(400, 'Error creating login user');
            }

            echo $jsonObj->toJSON();
            break;
        }
    case "loginname" : {
            if (!filter_has_var(INPUT_POST, 'json')) {
                $jsonObj = new ReturnMessage(400, 'No login information');
                echo $jsonObj->toJSON();
                die();
            }
            $json_array = json_decode(base64_decode(filter_input(INPUT_POST, 'json'), true), true);
            $login = new Login($json_array['username'], $json_array['passwordHash']);
            if ($login->isUserNameValid()) {
                $jsonObj = new ReturnMessage(200, 'Username is valid');
            } else {
                if ($login->existsStudent()) {
                    $jsonObj = new ReturnMessage(401, 'No login to ' . $json_array['username']);
                } else {
                    $jsonObj = new ReturnMessage(402, 'Username ' . $json_array['username'] . ' is invalid');
                }
            }
            echo $jsonObj->toJSON();
            break;
        }
    case "resetpassword" : {
            if (!filter_has_var(INPUT_POST, 'json')) {
                $jsonObj = new ReturnMessage(400, 'No login information');
                echo $jsonObj->toJSON();
                die();
            }
            $json_array = json_decode(base64_decode(filter_input(INPUT_POST, 'json'), true), true);
            //$now = 'A12345678a';
            $now = date('m-d-Y h:i:s a', time());
            $newpassword = substr(sha1($now), 0, 10);
            //
            // Salvar senha para que no caso de falha ... possa-se recupera-la
            //
            $login = new LoginUser($json_array['username'], $newpassword);

            // teste local
            //if ($login->resetPassword()) {
            //    $jsonObj = new ReturnMessage(200, 'Temporary password created');
            //    echo $jsonObj->toJSON();
            //    break;
            //}

            if ($login->resetPassword()) {
                $mailer = new AAEmail($json_array['username']);
                $mailer->setSourcemailaddress("aaclassroom@atmapps.pro.br");
                $mailer->setSourcename("Disciplinas ADS-AMS");
                $mailer->setSubject("[AAClassroom] Reset Password");
                $html = "<html><head><meta charset=\"UTF-8\"></head><body>Código: <b>" . $newpassword . "</b><p>";
                $html .= "<b>Este é o código para você realizar a redefinição de sua senha!</b></p><p>";
                $html .= "</body></html>";
                $mailer->setHtmlMessage($html);
                $mailer->prepare();
                if ($mailer->send()) {
                    $jsonObj = new ReturnMessage(200, 'Temporary password created');
                } else {
                    $jsonObj = new ReturnMessage(404, 'Reset password failure');
                }
            } else {
                $jsonObj = new ReturnMessage(400, 'temporary password not created');
            }
            echo $jsonObj->toJSON();
            break;
        }
    case "changepassword" : {
            if (!filter_has_var(INPUT_POST, 'json')) {
                $jsonObj = new ReturnMessage(400, 'No login information');
                echo $jsonObj->toJSON();
                die();
            }

            $json_received = base64_decode(filter_input(INPUT_POST, 'json'));
            $json_array = json_decode($json_received, true);
            $loginUser = new LoginUser($json_array['username'], $json_array['passwordHash'], $json_array['code']);

            $result = $loginUser->updateTempPassword();

            if ($result < 0) {
                $jsonObj = new ReturnMessage(404, 'Invalid code');
            } else {
                if ($result) {
                    $jsonObj = new ReturnMessage(200, 'Password changed with sucess');
                } else {
                    $jsonObj = new ReturnMessage(400, 'Error change to password');
                }
            }

            echo $jsonObj->toJSON();
            break;
        }

    case "classmate" : {
            if (!filter_has_var(INPUT_POST, 'json')) {
                $jsonObj = new ReturnMessage(400, 'No login information');
                echo $jsonObj->toJSON();
                die();
            }

            $json_received = base64_decode(filter_input(INPUT_POST, 'json'));
            $json_array = json_decode($json_received, true);
            $loginUser = new LoginUser($json_array['username'], $json_array['passwordHash'], $json_array['code']);
            try {
                $result = $loginUser->getStudentData();
                if (!is_array($result) || $result == null || !$result) {
                    $jsonObj = new ReturnMessage(400, 'Error on get data');
                } else {
                    $array_result = array();
                    foreach ($result as $key => $value) {
                        $array_result[$key] = $value;
                    }
                    $jsonObj = new ReturnMessage(200, 'Sucessfull');
                    $jsonObj->add("data", json_encode($array_result));
                }
            } catch (Exception $ex) {
                $jsonObjnew = new ReturnMessage(400, 'Error on get data');
            }
            echo $jsonObj->toJSON();
            break;
        }

    case "getassignments" : {
            if (!filter_has_var(INPUT_POST, 'json')) {
                $jsonObj = new ReturnMessage(400, 'No login information');
                echo $jsonObj->toJSON();
                die();
            }

            $json_received = base64_decode(filter_input(INPUT_POST, 'json'));
            $json_array = json_decode($json_received, true);
            $loginUser = new LoginUser($json_array['username'], $json_array['passwordHash'], $json_array['code']);

            try {
                $result = $loginUser->getAllAssignments();

                //var_dump(gettype($result));
                //var_dump(mb_detect_encoding($result, 'UTF-8, ISO-8859-1, ASCII'));
                //var_dump(utf8_encode($result));

                $jsonObj = new ReturnMessage(200, 'Sucessful');
                $jsonObj->add("data", base64_encode(iconv('ISO-8859-1', 'UTF-8', $result)));
            } catch (Exception $ex) {

                $jsonObj = new ReturnMessage(500, 'Error on search data');
                $jsonObj->add("Exception", $ex->getMessage());
            }

            echo $jsonObj->toJSON();
            break;
        }

    case "getstudentallinformation" : {

            $jsonObj = new ReturnMessage();

            if (!filter_has_var(INPUT_POST, 'json')) {
                $jsonObj = new ReturnMessage(400, 'No login information');
                echo $jsonObj->toJSON();
                die();
            }

            $json_received = base64_decode(filter_input(INPUT_POST, 'json'));
            $json_array = json_decode($json_received, true);
            $loginUser = new LoginUser($json_array['username'], $json_array['passwordHash'], $json_array['code']);

            try {
                $result = $loginUser->getAllStudentData();

                //var_dump(gettype($result));
                //var_dump(mb_detect_encoding($result, 'UTF-8, ISO-8859-1, ASCII'));
                //var_dump(utf8_encode($result));

                $jsonObj = new ReturnMessage(200, 'Sucessful');
                $jsonObj->add("data", base64_encode(iconv('ISO-8859-1', 'UTF-8', $result)));
            } catch (Exception $ex) {
                $jsonObj = new ReturnMessage(500, 'Error on search data');
            }

            echo $jsonObj->toJSON();

            break;
        }

    case "sendassignment" : {
            if (!filter_has_var(INPUT_POST, 'json')) {
                $jsonObj = new ReturnMessage(400, 'No login information');
                echo $jsonObj->toJSON();
                die();
            }

            $json_received = base64_decode(filter_input(INPUT_POST, 'json'));
            $json_array = json_decode($json_received, true);
            $loginUser = new LoginUser($json_array['username'], $json_array['passwordHash'], $json_array['code']);

            try {
                $assignmentInfo = array();
                $assignmentInfo['course_id'] = $json_array['course_id'];
                $assignmentInfo['subject_id'] = $json_array['subject_id'];
                $assignmentInfo['assignment_id'] = $json_array['assignment_id'];
                $assignmentInfo['student_ar'] = $json_array['student_ar'];
                $assignmentInfo['content'] = $json_array['content'];

                $result = $loginUser->writeAssignmentFinished($assignmentInfo);

                if ($result == 200) {
                    $jsonObj = new ReturnMessage(200, 'Sucessful');
                }
                $jsonObj->add("data", base64_encode(iconv('ISO-8859-1', 'UTF-8', $result)));
            } catch (Exception $ex) {
                $jsonObj = new ReturnMessage($ex->getCode(), $ex->getMessage());
            }

            echo $jsonObj->toJSON();

            break;
        }

    case "debug" : {
//$mailer = new AAEmail('tadeu.maffeis@gmail.com');
//$mailer->sendEmail('tadeu.maffeis@gmail.com');


            echo "<b>Version 1.0 - </b>" . date('m-d-Y h:i:s a', time()) . "\n\n\n";
            $mailer = new AAEmail('tadeu.maffeis@gmail.com');
            $mailer->setSourcemailaddress("disciplinas.tadeu.maffeis@gmail.com");
            $mailer->setSourcename("Disciplinas ADS-AMS");
            $mailer->setSubject("Disciplinas - Reset Password!");
            $html = "<html><head><meta charset=\"UTF-8\"></head><body>Código: <b>" . $newpassword . "</b><p>";
            $html .= "<b>Este é o código para você realizar a redefinição de sua senha!</b></p><p>";
            $html .= "</body></html>";
            $mailer->setHtmlMessage($html);
            $mailer->prepare();
            if ($mailer->send()) {
                $jsonObj = new ReturnMessage(200, 'Temporary password created');
            } else {
                $jsonObj = new ReturnMessage(404, 'Reset password failure');
            }
        }
        echo $jsonObj->toJSON();
        /*

          $obj = new AASqlTransactionGetStudentClassAssignment('tadeu.maffeis@fatec.sp.gov.br', "");
          $jsonStr = $obj->run();

          echo $jsonStr;

          break;


          $loginUser = new LoginUser("tadeu.maffeis@fatec.sp.gov.br", "AAAAAA", "95de8b4c24");

          $result = $loginUser->updateTempPassword();

          if ($result < 0) {
          $jsonObj = new ReturnMessage(404, 'invalid code');
          } else {
          if ($result) {
          $jsonObj = new ReturnMessage(200, 'Password changed with sucess');
          } else {
          $jsonObj = new ReturnMessage(400, 'Error change to password');
          }
          }

          echo $jsonObj->toJSON();


          /*
          $loginUser = new LoginUser("tadeu.maffeis@fatec.sp.gov.br");
          $result = $loginUser->existTempPassword();

          if ($result) {
          echo "\n\n***(Sucesso) Existe temppassword</p>";
          } else {
          echo "\n\n***Erro</p>";
          }
         */
        break;
}
/*
  $json_array = json_decode(base64_decode(filter_input(INPUT_POST, 'json'), true), true);
  $now = date('m-d-Y h:i:s a', time());
  $newpassword = substr(sha1($now), 0, 10);
  //
  // Salvar senha para que no caso de falha ... possa-se recupera-la
  //
  $gateway = new AALoginGateway($json_array['username'], $newpassword);

  if ($gateway->updatePassword()) {
  $mailer = new AAEmail($json_array['username']);
  $mailer->setSourcemailaddress("ed.ads.fitu@atmapps.pro.br");
  $mailer->setSourcename("Disciplina Estrutura de Dados");
  $mailer->setSubject("Disciplina Estrutura de Dados - Reset Password!");
  $html = "<html><body>Código: <b>" . $newpassword . "</b><p>";
  $html .= "<b>Clique no linK abaixo para resetar sua senha</b></p><p>";
  $html .= "http://www.classroom.atmapps.pro.br/ED/?resetpassword";
  $mailer->setHtmlMessage($html);
  $mailer->prepare();

  if ($mailer->send()) {
  $jsonObj = new ReturnMessage(200, 'Temporary password created');
  } else {
  $jsonObj = new ReturnMessage(404, 'Reset password failure');
  }
  } else {
  $jsonObj = new ReturnMessage(400, 'temporary password not created');
  }
  echo $jsonObj->toJSON();
  break;
  }

 */
/*
  if (!filter_has_var(INPUT_POST, 'json')) {
  $jsonObj = new ReturnMessage(400, 'Failure on reset password');
  echo $jsonObj->toJSON();
  die();
  }
  $json_array = json_decode(base64_decode(filter_input(INPUT_POST, 'json'), true), true);

  //$login = new Login($json_array['code'], $json_array['newpasswordHash']);
  //
  // Lógica para restar a senha
  //
  if ($login->isUserNameValid()) {
  $jsonObj = new ReturnMessage(200, 'Username is valid');
  } else {
  if ($login->existsStudent()) {
  $jsonObj = new ReturnMessage(400, 'No login to ' . $json_array['username']);
  }
  else
  {
  $jsonObj = new ReturnMessage(404, 'Username ' . $json_array['username'] . ' is invalid');
  }
  }
  echo $jsonObj->toJSON();
  break;
 * 
 */

function debug($maiiler) {

    $mailer->getHtmlMessage();

    die();
}
