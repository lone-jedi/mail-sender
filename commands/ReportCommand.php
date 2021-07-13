<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class ReportCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "report";

    /**
     * @var string Command Description
     */
    protected $description = "отчет по новым клиентам";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        // $this->replyWithMessage(['text' => var_export($this->getTelegram()->getWebhookUpdates(), true)]);
        
        $args = explode(' ', $arguments);
        
        if(count($args) == 0) {
            $keyboard = [
                ['7', '8', '9'],
                ['4', '5', '6'],
                ['1', '2', '3'],
                     ['0']
            ];
            
            // $keyboard = [
            //     ['text'=>'', 'callback_data'=>'smth'],
            //     ['text'=>'', 'callback_data'=>'smth2']
            // ];

            $this->replyWithMessage([
                'text' => 'Введите что-то', 
                'reply_markup' => $this->getTelegram()->replyKeyboardMarkup([
                                        'keyboard' => $keyboard, 
                                        'resize_keyboard' => true, 
                                        'one_time_keyboard' => true
                                    ])
            ]);
        }
        
        
        
    }
}