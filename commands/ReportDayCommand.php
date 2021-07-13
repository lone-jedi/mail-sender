<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class ReportDayCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "reportDay";

    /**
     * @var string Command Description
     */
    protected $description = "отчет по новым клиентам";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        
        
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $telegram = $this->getTelegram();

        $updates =  $telegram->getWebhookUpdates();
        
        $chatId = $updates['message']['chat']['id'];
        
        try {
            $clients = Registry::getProperty('db_instance')->dbQuery('SELECT * FROM `clients` WHERE DATE(date_add) = CURDATE()')->fetchAll();
            
            $this->replyWithMessage(['text' => 'Сегодня новых заявок: '. count($clients)]);
        } 
        catch(\Exception $e) {
            $this->replyWithMessage(['text' => 'Ошибка при выполнении запроса']);
        }
        
        $this->replyWithMessage(['text' => var_export($arguments, true)]);
    }
}