<?php
require_once 'init.php';

// Get phones array from phones file 
$phones = explode(' ', file_get_contents(__DIR__ . '/tmp_phones.txt'));

if(!empty($phones)) {
    $resp = Sms::send( 'YOUR SMS TEXT', $phones );
}

// Delete phones file 
unlink(__DIR__ . '/tmp_phones.txt');

print_r($resp);