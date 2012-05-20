<?php
include('config.php');

$_POST['contactDepartment'] == 'Webmaster' ? $sendTo = $webEmail : $sendTo = $contactEmail;
$subject = 'DeSalvo Custom Cycles Web Email: ' . $_POST['contactSubject'];
$headers = 'From: '.$infoEmail . "\r\n" .
    'Reply-To: ' . $infoEmail . "\r\n" .
    'X-Mailer: PHP/' . phpversion() .
	'MIME-Version: 1.0' . "\r\n" .
	'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$message = '
<html>
<head>
    <title>' . $subject . '</title>
</head>
<body style="font-family:arial, helvetica, san-serif">

    <h4 style="margin:0">'.$_POST["contactSubject"].'</h4>
    <p style="font-size:12px; margin:0;">From: <strong>'.$_POST["contactName"].'</strong></p>
    <p style="font-size:12px; margin:0;">Email Address: <strong><a href="mailto:'.$_POST["honeyPot"].'">'.$_POST["honeyPot"].'</a></strong></p>
    <p style="font-size:12px; margin:0;">Department: <strong>'.$_POST["contactDepartment"].'</strong></p>

    <h4 style="margin:10px 0 0;">Message:</h4>
    <p style="font-size:12px; margin:0;">'.$_POST["contactComment"].'</p>

</body>
</html>
';

if (!$_POST['contactEmail']) {
    mail($sendTo, $subject, $message, $headers);

    header('Location: http://www.desalvocycles.com/contact.php?complete=true');
    exit;
} else {
    header('Location: http://www.desalvocycles.com/contact.php?complete=spam');
    exit;
}


?>
