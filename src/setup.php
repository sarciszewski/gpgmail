<?php
require "Crypt/GPG.php";

$gpg = new Crypt_GPG(
    array(
        'homedir' => __DIR__
    )
);
$import = $gpg->importKeyFile(__DIR__.'/public/public.asc');
var_dump($import);
