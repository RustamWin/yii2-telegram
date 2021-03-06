<?php
/**
 * @copyright Copyright (c) 2017. ActiveMedia Solutions LLC
 * @author    Rustam Mamadaminov <rmamdaminov@gmail.com>
 */

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\ReplyKeyboardHide;
use Longman\TelegramBot\Request;

/**
 * User "/cancel" command
 *
 * This command cancels the currently active conversation and
 * returns a message to let the user know which conversation it was.
 * If no conversation is active, the returned message says so.
 */
class CancelCommand extends UserCommand
{
    /**#@+
     * {@inheritdoc}
     */
    protected $name = 'cancel';
    protected $description = 'Cancel the currently active conversation';
    protected $usage = '/cancel';
    protected $version = '0.1.1';
    protected $need_mysql = true;
    public $enabled = false;
    
    /**#@-*/

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $text = 'No active conversation!';

        //Cancel current conversation if any
        $conversation = new Conversation(
            $this->getMessage()->getFrom()->getId(),
            $this->getMessage()->getChat()->getId()
        );

        if ($conversation_command = $conversation->getCommand()) {
            $conversation->cancel();
            $text = 'Conversation "' . $conversation_command . '" cancelled!';
        }

        return $this->hideKeyboard($text);
    }

    /**
     * {@inheritdoc}
     */
    public function executeNoDb()
    {
        return $this->hideKeyboard('Nothing to cancel.');
    }

    /**
     * Hide the keyboard and output a text
     *
     * @param string $text
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     */
    private function hideKeyboard($text)
    {
        return Request::sendMessage([
            'reply_markup' => new ReplyKeyboardHide(['selective' => true]),
            'chat_id'      => $this->getMessage()->getChat()->getId(),
            'text'         => $text,
        ]);
    }
}
