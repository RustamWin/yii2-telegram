<?php
/**
  * @copyright Copyright &copy; Rustam Mamadaminov (RustamWin)
  * @package   telegram
  * Date: 09.06.2017
  */
namespace rustam95\telegram;
use yii\base\UserException;

/**
 * telegram module definition class
 */
class Module extends \yii\base\Module implements \yii\base\BootstrapInterface
{
    public $API_KEY = null;
    public $BOT_NAME = null;
    public $hook_url = null;
    public $PASSPHRASE = null;
    public $userCommandsPath = null;
    public $timeBeforeResetChatHandler = 0;
    public $db = 'mongodb';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'rustam95\telegram\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->API_KEY) || empty($this->BOT_NAME) || empty($this->hook_url))
            throw new UserException('You must set API_KEY, BOT_NAME, hook_url');
        if (empty($this->PASSPHRASE))
            throw new UserException('You must set PASSPHRASE');
        parent::init();

        // set up i8n
        if (empty(\Yii::$app->i18n->translations['tlgrm'])) {
            \Yii::$app->i18n->translations['tlgrm'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
                //'forceTranslation' => true,
            ];
        }
    
    }

    public function bootstrap($app)
    {
        if ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'rustam95\telegram\commands';
        }
    }
}
