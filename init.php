<?php

require_once 'config.php';

require_once 'core/Registry.php';
require_once 'core/DbInstance.php';
require_once 'core/DbModel.php';

require_once 'bitrix/crest.php';
require_once 'bitrix/bitrix.php';

require_once 'yandex/YandexMail.php';

require_once 'telegram/telegram.php';

require_once 'commands/ListCommand.php';
require_once 'commands/StartCommand.php';
require_once 'commands/StopCommand.php';
require_once 'commands/ReportCommand.php';
require_once 'commands/ReportDayCommand.php';
require_once 'commands/CloseCommand.php';

require_once 'models/Client.php';
require_once 'models/Sms.php';

use Telegram\Bot\Commands\Registry;

Registry::setProperty('db_instance', new DbModel(DB_HOST, DB_NAME, DB_USER, DB_PASS));

date_default_timezone_set('UTC');