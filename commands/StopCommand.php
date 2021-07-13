<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;


class StopCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "stop";

    /**
     * @var string Command Description
     */
    protected $description = "останавливает бота";

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
            $rows = Registry::getProperty('db_instance')->dbQuery('UPDATE `chats` SET `status`= "DELETED" WHERE `chat_id` = :chat_id', ['chat_id' => $chatId])->rowCount();
            if($rows == 0) {
                $this->replyWithMessage(['text' => 'Ошибка: вы уже отписались от бота или еще не выполнили команду /start. Вот список доступных команд:']);
            } else {
                $this->replyWithMessage(['text' => 'Вы отписались от бота. Вот список доступных команд:']);
            }
            
        } 
        catch(\Exception $e) {
            $this->replyWithMessage(['text' => 'Ошибка выполнения запроса. Вот список доступных команд:']);
        }
        
        $this->triggerCommand('list');
    }
}