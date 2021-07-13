<?php
// API токен Телеграм
define( 'TELEGRAM_BOT_API_TOKEN', '' );

// API токен СМС сервиса
define('SMS_API_TOKEN', '');

// URL для запросов к СМС сервису
define('SMS_URL', '');

// Битрикс вебхук
define( 'C_REST_WEB_HOOK_URL','' );

// Частота выполнения скрипта 60сек * 5 + 4сек(буферное время работы скрипта)
define( 'DURATION', 60 * 5 + 4 );
// define( 'DURATION', 60 );

// Колличество последних входящих емейлов которые будут проверяться за промежуток выполнения скрипта
define( 'MAX_EMAILS_COUNT_BY_TICK', 10 );

// Емейл от почты
define( 'MAIL_USER', 'example@mail.com' );
/**
* Пароль от почты 
* Для Яндекса создать и указать пароль созданный для приложений POP3
*/
define( 'MAIL_PASS', '' );

// Подключение к Базе Данных
define( 'DB_HOST', 'localhost' );
define( 'DB_NAME', 'db_name' );
define( 'DB_USER', 'root' );
define( 'DB_PASS', '' );



