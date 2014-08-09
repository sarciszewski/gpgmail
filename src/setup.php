<?php
define('BASE', __DIR__);
putenv('GNUPGHOME='.BASE.'/.gnupg');
touch(BASE.'/.gnupg');
chown(BASE.'/.gnupg', 'www-data');
chmod(BASE.'/.gnupg', 0700);

$gpg = new gnupg();
$data = $gpg->import(file_get_contents(BASE.'/public/public.asc'));

file_put_contents(BASE."/public/public.asc.fp", $info['fingerprint']);