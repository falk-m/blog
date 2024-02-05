<?php

use PHPMailer\PHPMailer\PHPMailer;

error_reporting(E_ALL);
ini_set("display_errors", 1);

// Setup mail headers.
$headers = array(
    "To" => "mail@falk-m.de",
    "From" => "testsender@falk-m.de",
    "Subject" => "a encrypted message.",
);

$message = "this is a secred text";

$tempBodyFile = @tempnam("temp", "email");
$tempEncfFile = @tempnam("temp", "emailenc");
file_put_contents($tempBodyFile, $message);

// Sign the message first
//openssl_pkcs7_sign(
//    "msg.txt",
//    "signed.txt",
//    "signing_cert.pem",
//    array(
//        "private_key.pem",
//        "password"
//    ),
//    array()
//);

// Get the public key certificate.
$pubkey = file_get_contents(__DIR__ . "/certificate.crt");

//encrypt the message, now put in the headers.
$success = openssl_pkcs7_encrypt(
    $tempBodyFile,
    $tempEncfFile,
    $pubkey,
    $headers,
    PKCS7_TEXT,
    1
);

if (!$success) {
    throw new Exception('mail encryption error');
}

$data = file_get_contents($tempEncfFile);

// separate header and body, to use with mail function
//  unfortunate but required, else we have two sets of headers
//  and the email client doesn't decode the attachment
[$header, $body] = explode("\n\n", $data, 2);


print_r(
    [$header, $body]
);

require './vendor/autoload.php';

//extend php mailer to send raw messages
class CustomMailer extends PHPMailer
{

    public function sendSmtpSend(string $header, string $body)
    {
        return $this->smtpSend($header, $body);
    }
}

$config = require('config.php');

$phpmailer = new CustomMailer();
$phpmailer->SMTPDebug = 2;
$phpmailer->isSMTP();
$phpmailer->Host = $config['host'];
$phpmailer->SMTPAuth = true;
$phpmailer->Username = $config['username'];
$phpmailer->Password = $config['password'];
$phpmailer->SMTPSecure = $config['smtpSecure'];
$phpmailer->Port = $config['port'];

/*
$phpmailer->setFrom('testsender@falk-m.de');
$phpmailer->addAddress('mail@falk-m.de');

$phpmailer->isHTML(true);
$phpmailer->Subject = 'Here is the subject';
$phpmailer->Body    = 'This is the HTML message body <b>in bold!</b>';

$mailSend  = $phpmailer->send();
*/

$phpmailer->setFrom($headers["From"]);
$phpmailer->addAddress($headers["To"]);
$mailSend = $phpmailer->sendSmtpSend($header, $body);

if ($mailSend) {
    echo 'OK';
} else {
    echo 'FAIL';
}


// send mail (headers in the Headers parameter will override those
//  generated for the To & Subject parameters)
//mail($mail, $subject, $parts[1], $parts[0]);
