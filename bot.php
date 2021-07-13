<?php

require_once('vendor/autoload.php');
require_once('init.php');

use Telegram\Bot\Api;
use Telegram\Bot\Commands\{StartCommand, StopCommand, ReportCommand, CloseCommand, ListCommand, ReportDayCommand};

$telegram = new Api(TELEGRAM_BOT_API_TOKEN);

$telegram->addCommands([
    StartCommand::class, 
    StopCommand::class,
    ReportCommand::class,
    CloseCommand::class,
    ListCommand::class,
    ReportDayCommand::class,
]);

$update = $telegram->commandsHandler(true);