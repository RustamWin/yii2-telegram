<?php
/**
 * @copyright Copyright (c) 2017. ActiveMedia Solutions LLC
 * @author    Rustam Mamadaminov <rmamdaminov@gmail.com>
 */

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use Yii;

/**
 * User "/help" command
 */
class HelpCommand extends UserCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'help';
    protected $description = '';
    protected $usage = '/help or /help <command>';
    protected $version = '1.0.1';
    /**#@-*/

    public function __construct($telegram, $update = NULL)
    {
        $this->description = \Yii::t('tlgrm', 'Show bot commands help');
        parent::__construct($telegram, $update);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $message = $this->getMessage();
        $chat_id = $message->getChat()->getId();

        $message_id = $message->getMessageId();
        $command = trim($message->getText(true));

        //Only get enabled Admin and User commands
        $commands = array_filter($this->telegram->getCommandsList(), function ($command) {
            return (!$command->isSystemCommand() && $command->isEnabled());
        });

        //If no command parameter is passed, show the list
        if ($command === '') {
            $text = $this->telegram->getBotName() . ' v. ' . $this->telegram->getVersion() . "\n\n";
            $text .= 'Commands List:' . "\n";
            foreach ($commands as $command) {
                $text .= '/' . $command->getName() . ' - ' . $command->getDescription() . "\n";
            }

            $text .= "\n" . 'For fast exact command help type: /help <command>';
        } else {
            $command = str_replace('/', '', $command);
            if (isset($commands[$command])) {
                $command = $commands[$command];
                $text = 'Command: ' . $command->getName() . ' v' . $command->getVersion() . "\n";
                $text .= 'Description: ' . $command->getDescription() . "\n";
                $text .= 'Usage: ' . $command->getUsage();
            } else {
                $text = 'No help available: Command /' . $command . ' not found.';
            }
        }

        $data = [
            'chat_id'             => $chat_id,
            'reply_to_message_id' => $message_id,
            'text'                => $text,
        ];

        return Request::sendMessage($data);
    }
}
