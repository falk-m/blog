---
title: 'encrypt emails with s/mime on PHP and send with PHPMailer over smtp'
taxonomy:
    tag:
        - PHP
date: '25-01-2024'
---

php mail can sign messages but not encrypt them.
For a project, i have to encrypt the mail Body with php.

First, I have to receive the public key from the recipient.
In my case, I test it with the s/mime certificate of my post box.

Here are the message body and the header parameters:

```php
$headers = array(
    "To" => "mail@falk-m.de",
    "From" => "testsender@falk-m.de",
    "Subject" => "a encrypted message.",
);

$message = "this is a secred text";
```

For the encryption method, we need the message text in a file and we need a file for the encryption output.

```php
$tempBodyFile = @tempnam("temp", "email");
file_put_contents($tempBodyFile, $message);

$tempEncfFile = @tempnam("temp", "emailenc");
```

Read the certificate from the recipient to a string variable.

```php
$pubkey = file_get_contents(__DIR__ . "/certificate.crt");
```

If you want to signate the message, then use first the ```openssl_pkcs7_sign``` function to signate the content, before you encrypt the content with the ```openssl_pkcs7_encrypt``` function.
You find some examples on the internet. In my case, this is not necessary, because I only want to encrypt the content.
I want a secure transport of sensitive data, not the verification from the sender of the mail.

Now, we use an openssl function for the encryption:

```php
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
```

The PKCS7_TEXT flag is important.

After the encryption, we read the encrypted content and separate the mail header and body string. 
```php
$data = file_get_contents($tempEncfFile);

// separate header and body, to use with mail function
[$header, $body] = explode("\n\n", $data, 2);
```

Finish. We can send the mail:

```
mail($headers['To'], $headers['Subject'], $body, $header);
```

---

## send encrypted mails over SMTP using PHPMailer

The PHPMailer has no support for encrypted mail.
Also, there is no function to send Mails with raw header and body text.

Here is a simple extension to send smtp-mails with raw message data:

```php
class CustomMailer extends PHPMailer
{

    public function sendSmtpSend(string $header, string $body)
    {
        return $this->smtpSend($header, $body);
    }
}
```

We use the internal ```smtpSend``` method, so we have to set a recipient and the from-address for the communication in the SMTP protocol.

```php
$phpmailer = new CustomMailer();
$phpmailer->SMTPDebug = 0;
$phpmailer->isSMTP();
$phpmailer->Host = '--insert--';
$phpmailer->SMTPAuth = true;
$phpmailer->Username = '--insert--';
$phpmailer->Password ='--insert--';
$phpmailer->SMTPSecure = '--insert--';
$phpmailer->Port = '--insert--';

$phpmailer->setFrom($headers["From"]);
$phpmailer->addAddress($headers["To"]);
$mailSend = $phpmailer->sendSmtpSend($header, $body);

if ($mailSend) {
    echo 'OK';
} else {
    echo 'FAIL';
}
```

## source

- https://www.php.net/manual/de/function.openssl-pkcs7-encrypt.php