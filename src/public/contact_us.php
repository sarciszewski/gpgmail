<?php
require "Mail.php";
require "Mail_Mime.php";
require "Crypt/GPG.php";

define('BASE', dirname(__DIR__));

if (isset($_POST['from']) && isset($_POST['message'])) {
	$gpg = new Crypt_GPG(array(
        'homedir' => BASE
    ));
    $gpg->importKeyFile(__DIR__.'/public.asc');
	
	$ciphertext = $gpg->encrypt(
		"From: {$_POST['from']}\n\nMessage:\n{$_POST['message']}"
	);
	
	$email = Mail::factory('mail');
	$email->send(
		[$email], // Just for the lulz
		['From' => 'Contact Form <contact@anonymo.us>'],
		$ciphertext
	);
	header("Location: contact_form.php?msg=success");
	exit;
}
header("Location: contact_form.php");
exit;
