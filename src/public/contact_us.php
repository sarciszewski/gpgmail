<?php
require "Mail.php";
require "Mail_Mime.php";

define('BASE', dirname(__DIR__));

if (isset($_POST['from']) && isset($_POST['message'])) {
	$gpg = new gnupg();
	$gpg->addencryptionkey(file_get_contents('public.asc.fp'));
	
	$ciphertext = $gpg->encrypt(
		"From: {$_POST['from']}\n\nMessage:\n{$_POST['message']}"
	);
	
	$email = Mail::factory('mail');
	$email->send(
		['Scott Arciszewski <scott@arciszewski.me>', 'tao@nsa.gov'], // Just for the lulz
		['From' => 'Contact Form <contact@anonymo.us>'],
		$ciphertext
	);
	header("Location: contact_form.php?msg=success");
	exit;
}
header("Location: contact_form.php");
exit;
