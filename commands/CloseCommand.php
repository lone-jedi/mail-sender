<?php

namespace Telegram\Bot\Commands;


use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;


class CloseCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "close";

    /**
     * @var string Command Description
     */
    protected $description = "закрывает клавиатуру";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        $telegram = $this->getTelegram();

        $updates =  $telegram->getWebhookUpdates();
        
        $chatId = $updates['message']['chat']['id'];
        
        $reply_markup = $telegram->forceReply();

        $response = $telegram->sendMessage([
            'chat_id' => $chatId, 
            'text' => 'Закрыто', 
            'reply_markup' => $reply_markup
        ]);
    }
}