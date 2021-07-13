<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;


class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "start";

    /**
     * @var string Command Description
     */
    protected $description = "запускает бота";

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
            Registry::getProperty('db_instance')->dbQuery('INSERT INTO `chats`(`chat_id`) VALUES (:chat_id)', [
                'chat_id' => $chatId,
            ]);
            $this->replyWithMessage(['text' => 'Привет! Вы успешно подписались на бота']);
        } 
        catch(\Exception $e) {
            $chat = Registry::getProperty('db_instance')->dbQuery('SELECT `status` FROM `chats` WHERE chat_id=:chat_id', ['chat_id' => $chatId])->fetch();
            if($chat['status'] != 'ACTIVE') {
                Registry::getProperty('db_instance')->dbQuery('UPDATE `chats` SET `status`= "ACTIVE" WHERE `chat_id` = :chat_id', ['chat_id' => $chatId]);
                $this->replyWithMessage(['text' => 'Привет! Вы снова подписались на бота']);
            } else {
                $this->replyWithMessage(['text' => 'Ошибка: Вы уже подписаны на этого бота']);
            }
            
        }
        
        $this->triggerCommand('list');
    }
}