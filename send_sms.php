<?php
require_once 'config.php';
require_once 'models/Sms.php';

// Get phones array from phones file 
$phones = explode(PHP_EOL, file_get_contents(__DIR__ . '/tmp_phones.txt'));

if(!empty($phones)) {
    $resp = Sms::send( 'YOUR SMS TEXT', $phones );
}

// Delete phones file 
unlink(__DIR__ . '/tmp_phones.txt');

print_r($resp);