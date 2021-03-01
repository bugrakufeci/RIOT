<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
// Gerekli dosyaları include ediyoruz
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';
date_default_timezone_set('Etc/UTC');
$mail = new PHPMailer(true);

// an email address that will be in the From field of the email.
$from = 'info@riot.com.tr';

// an email address that will receive the email with the output of the form
$sendTo = 'info@riot.com.tr';

// subject of the email
$subject = 'RIOT - Contact Form';

// form field names and their translations.
// array variable name => Text to appear in the email
$fields = array('name' => 'Name', 'email' => 'Email', 'phone' => 'Phone', 'subject' => 'Subject', 'message' => 'Message'); 

// message that will be displayed when everything is OK :)
$okMessage = 'Mesajınızı aldık. En yakın zamanda size ulaşacağız!';

// If something goes wrong, we will display this message.
$errorMessage = 'Bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.';

/*
 *  LET'S DO THE SENDING
 */

// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);


    $mail->SMTPDebug = 2;
    
    $mail->isSMTP();
    $mail->CharSet = 'utf-8';
    $mail->Host       = 'mail.riot.com.tr';
    $mail->SMTPAuth   = true; 
    $mail->Username   = 'info@riot.com.tr'; 
    $mail->Password = "hIeVGlCc7V9v"; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
    $mail->Port       = 465; 
    $mail->setFrom('info@riot.com.tr', 'R-IoT Info'); 
    $mail->addAddress('info@riot.com.tr', 'R-IoT Info');
    if(count($_POST) == 0) throw new \Exception('Form is empty');
            
    $emailText = "Yeni bir iletişim formu iletildi.\n=====================================\n";

    foreach ($_POST as $key => $value) {
        // If the field exists in the $fields array, include it in the email 
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    // All the neccessary headers for the email.
    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );

    $mail->isHTML(false); 
    $mail->Subject = 'İletişim Formu';
    $mail->Body    = $emailText;
    
    // Send email
    
     $responseArray = array('type' => 'success', 'message' => $okMessage);


$encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
