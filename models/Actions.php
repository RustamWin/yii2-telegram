<?php
/**
 * @copyright Copyright (c) 2017. ActiveMedia Solutions LLC
 * @author    Rustam Mamadaminov <rmamdaminov@gmail.com>
 */
namespace rustam95\telegram\models;


/**
 * This is the model class for table "actions".
 *
 * @property integer $chat_id
 * @property string  $action
 * @property string  $param
 */
class Actions extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return 'tg_actions';
    }

    public function attributes()
    {
        return [
            '_id',
            'chat_id',
            'action',
            'param',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chat_id'], 'required'],
            [['chat_id'], 'integer'],
            [['action', 'param'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'chat_id' => 'User ID',
            'action'  => 'Action',
            'param'   => 'Parameter',
        ];
    }
}
