<?php

use Telegram\Bot\Api;
use Telegram\Bot\Commands\Registry;

class Telegram
{
    private $telegram;
    
    public function __construct($token) 
    {
        $this->telegram = new Api($token);
    }
    
    public function instance() 
    {
        return $this->telegram;
    }
    
    public function sendToChats($message) 
    {
        $chatsIds = $this->getChatIds();
        foreach($chatsIds as $chatsId) {
            if($chatsId['chat_id']) {
                $this->telegram->sendMessage([ 'chat_id' => $chatsId['chat_id'], 'text' => $message ]); 
            }
        }  
    }
    
    public function getChatIds()
    {
        return Registry::getProperty('db_instance')->dbQuery('SELECT * FROM `chats` WHERE status = "ACTIVE"')->fetchAll();
    }
    
}