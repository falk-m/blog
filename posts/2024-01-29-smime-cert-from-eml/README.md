---
title: 'Extract SMIME certificate from mail'
taxonomy:
    tag:
        - security
date: '2024-01-29'
---

In an [earlier post](../04-smime-mail-encyption/README.md), I dircript how you can sent a s/mime encrypted mail.
If you want to send encrypted mail, you need the public certificate from the recipient's email address.
One way to recive this is, that the recipient sent a signed mail to you.
The signature include the public certificate.

## 1. store email

Store the email in your mail client als eml file.
You can also forward the email to yourself as an attachment file.
Attached emails are also in eml format.

## 2. extract Signamture.

the eml file includes a p7s part.

```
------=_NextPart_000_0000_01DA529E.150CC600
Content-Type: application/pkcs7-signature;
	name="smime.p7s"
Content-Transfer-Encoding: base64
Content-Disposition: attachment;
	filename="smime.p7s"

MIAGCSqGSIb3DQEHAqCAMIACAQExCzAJBgUrDgMCGgUAMIAGCSqGSIb3DQEHAQAAoIIYajCCBbow
ggOioAMCAQICCQC7QBxD9V5PsDANBgkqhkiG9w0BAQUFADBFMQswCQYDVQQGEwJDSDEVMBMGA1UE
...
```

You can use mpack (```sudo apt-get install mpack```) to extract all parts from the eml file.

After executeing ```munpack mail.eml```, you have a separate 'smime.p7s' file 


## 3. extract certificate

 ```openssl pkcs7 -in smime.p7s -inform DER -print_certs``` show you all certificates (personal, root, ...) from the p7s file.

You need the certificate with recipient's mail address as subject.

```
subject=CN = smimetest@falk-m.de, emailAddress = smimetest@falk-m.de

issuer=C = CH, O = SwissSign AG, CN = SwissSign RSA SMIME LCP ICA 2022 - 1

-----BEGIN CERTIFICATE-----
MIIGLTCCBBWgAwIBAgIUBKyN2G9ORjyDcMLyswYPxdSJ8OUwDQYJKoZIhvcNAQEL
...
HLP32b+f9FiEJPYDTyvh3BhOYMrV3rSl7YRFRn5TySwVcdgxr9dNcVBb1T2ZKfOS
MFTC5FAut3GpgpW7X+yaRQaH/ybbqSWO9zIICv/4BGVUtqmCNpD8t+D2OIQYS+Pq
SQ==
-----END CERTIFICATE-----
```

Copy all from including '-----BEGIN CERTIFICATE-----' to including '-----END CERTIFICATE-----' in a new created empty text file and rename it to 'mail.crt'.