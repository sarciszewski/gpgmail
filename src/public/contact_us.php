<?php
require "Mail.php";
require "Mail_Mime.php";
require "Crypt/GPG.php";

define('BASE', dirname(__DIR__));
require BASE.'/config.php';


if (isset($_POST['from']) && isset($_POST['message'])) {
	$gpg = new Crypt_GPG([
        'homedir' => BASE
    ]);
    $fingerprint = $gpg->getFingerprint(
        OUR_EMAIL_ADDRESS
    );
	
	$ciphertext = $gpg->encrypt(
		"From: {$_POST['from']}\n\nMessage:\n{$_POST['message']}",
        $fingerprint
	);
	
	$email = Mail::factory('mail');
	$email->send(
		[OUR_EMAIL_ADDRESS], // Just for the lulz
		['From' => 'Contact Form <contact@anonymo.us>'],
		$ciphertext
	);
	header("Location: contact_form.php?msg=success");
	exit;
}
header("Location: contact_form.php");
exit;
