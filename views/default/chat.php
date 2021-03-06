<?php
/**
 * @copyright Copyright (c) 2017. ActiveMedia Solutions LLC
 * @author    Rustam Mamadaminov <rmamdaminov@gmail.com>
 */

use yii\helpers\Html;

echo Html::beginTag('div', ['id' => 'tlgrm-chat']);
echo Html::tag('div', Html::tag('div', '',['id' => 'tlgrm-close-btn']),['id' => 'tlgrm-chat-head']);
echo Html::tag('div', '',['id' => 'tlgrm-chat-flow']);
echo Html::beginTag('div', ['id' => 'tlgrm-chat-send-panel']);
echo Html::beginForm('/telegram/chat/send-msg', 'post', ['id' => 'tlgrm-chat-form']);
echo Html::textarea('message', '', ['class' => "form-control", 'id' => 'tlgrm-chat-msg', 'minlength'=>"1", 'required' => 'required',]);
echo Html::submitButton('<i class="glyphicon glyphicon-send"></i>', ['class' => 'btn btn-primary', 'id' => 'tlgrm-send-btn']);
echo Html::endForm();
echo Html::endTag('div');
echo Html::endTag('div');