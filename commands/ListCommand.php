<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;


class ListCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "list";

    /**
     * @var string Command Description
     */
    protected $description = "список всех доступных команд";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        $this->replyWithMessage(['text' => 'Все доступные команды:']);
        
        $telegram = $this->getTelegram();
        
        $commands = $telegram->getCommands();

        $response = '';
        foreach ($commands as $name => $command) {
            $response .= sprintf('/%s - %s' . PHP_EOL, $name, $command->getDescription());
        }

        $this->replyWithMessage(['text' => $response]);
    }
}