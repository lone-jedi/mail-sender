<?php

require_once 'vendor/autoload.php';
require_once 'init.php';

// Connect to Yandex mail server
$mail_server = new YandexMail(MAIL_USER, MAIL_PASS);

// If all goes wrong use this
// BUT Extremely slow
// $ids = $mail_server->getEmailsIdByToday();

// Latest letters ids
$ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

$mails = $mail_server->getAllEmailsByDuration(DURATION, $ids, ['allowed_emails' => [
    
    'support@meedget.ru' => function($mail) {
        $text = explode("Нужно больше заявок?", str_replace('<br>', PHP_EOL , strip_tags($mail['body'], '<br>')));
        $text = explode("«Сколько стоит лечение - doctorblago.com.ua»", $text[0]);
        preg_match('/\d{9,18}/', $text[1], $phone);
        return ['user_name' => 'Meedget', 'user_phone' => $phone[0], 'text_message' => $text[1]];
    },
    
    'mail@doctorblago.com.ua' => function($mail) {
        $input = str_replace('<br>', PHP_EOL , strip_tags($mail['body']));
        $text = explode('|', $input);  
        // Temporary condition 
        if($text[1] == '%%phone%%') return [];
        return [ 'user_name'    => $text[0], 
                 'user_phone'   => $text[1], 
                 'user_email'   => $text[2] ?? null, 
                 'text_message' => (isset($text[0]) ? 'Имя: ' . $text[0] .  PHP_EOL : '')  . 
                                   (isset($text[1]) ? 'Телефон: ' . $text[1] .  PHP_EOL : '') . 
                                   (isset($text[2]) ? 'Email: ' . $text[2] .  PHP_EOL : '') . 
                                   (isset($text[3]) ? 'Текст: ' . $text[3] : '')
        ];
    }
    ]]);

$mail_server->closeConnection();

$mailsTime = microtime(true);

print_r($mails);

if(!empty($mails)) {

    foreach($mails as $key => $mail) {
        // Add to DataBase
        Client::add($mail['user_name'], $mail['user_phone'], $mail['user_email'], $mail['text_message']);
        
        // Send to Telegram
        // $telegram = new Telegram(TELEGRAM_BOT_API_TOKEN);
        $telegram->sendToChats($mail['text_message']);
        
        // Send to Bitrix
        Bitrix::addDeal($mail['user_name'], $mail['user_phone']);
        
        // Work with SMS
        date_default_timezone_set('Europe/Kiev');
        // Get int from 24 format hour
        $hour = intval(date('G'));
        if($hour >= 9 && $hour < 21) {
        	// Send to SMS service
            $resp = Sms::send('YOUR SMS TEXT', [ $mail['user_phone'] ]);
        } else {
        	// Add phone to file and send sms to all phones from file at 9:00 am (cron task)
            file_put_contents(__DIR__ . '/tmp_phones.txt', $mail['user_phone'], FILE_APPEND );
        }
        
        print_r($resp);
    }

}