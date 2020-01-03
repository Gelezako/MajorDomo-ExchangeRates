<?php
/**
 * Ukraine language file for ExchangeRates module
 *
 * @package ExchangeRates
 * @author Alex Sokolov <admin@gelezako.com> http://blog.gelezako.com
 * @version 1.0
 *
 **/

$dictionary = array(
/* general */
'ER_SCRIPT_NAME'=>'Назва сценарію',
'ER_APP_ABOUT' => 'Про модуль',
'ER_APP_CLOSE' => 'Закрити',
'ER_APP_MODULE' => 'Модуль',
'ER_APP_PROJ' => 'Проект у',
'ER_APP_DONATE' => 'Підтримати розробку і розвиток модуля:',
'ER_APP_DONATE2' => 'Сторінка для доната у:',
'ER_APP_DONATE3' => 'Внутрішній рахунок у',
'ER_APP_Author' => 'Автор',
'ER_APP_NAME' => 'Курс валют',
'ER_APP_TITLE' => 'Виберіть тип валюти,<br>який хочете отримати',
'ER_APP_BANK_UA' => 'Комерційний курс ПриватБанку',
'ER_APP_NOTIF' => 'Неможливо отримати курс валют ПриватБанку',
'ER_APP_NOTIF2' => 'Неможливо отримати курс валют Банку Росії',
'ER_APP_NOTIF3' => 'Неможливо отримати курс валют НБУ',
'ER_APP_NOTIF4' => 'Неможливо отримати курс валют Нац Банку Казахстану',
'ER_APP_NOTIF5' => 'Неможливо отримати курс валют Нац Банку Республіки Беларусь',

//Пари валют
'ER_APP_EU_HR' => 'Пара: Євро \ Гривня',
'ER_APP_DO_HR' => 'Пара: Долар \ Гривня',
'ER_APP_RU_HR' => 'Пара: Рубль \ Гривня',

'ER_APP_BANK_RU' => 'Курс Банку Росії',
'ER_APP_DO_RU' => 'Пара: Долар \ Рубль',
'ER_APP_EU_RU' => 'Пара: Євро \ Рубль',

'ER_APP_BANK_NBU' => 'Курс НБУ',
'ER_APP_SOUND' => 'Озвучити',
'ER_APP_DISCUS' => 'Обговорення модуля на форумі',
'ER_APP_INFO' => 'Курс НБУ надано порталом',
'ER_APP_MINFIN' => 'Мінфін',

'ER_APP_BANK_KZ' => 'Курс Нац Банку Казахстану',
'ER_APP_DO_KZ' => 'Пара: Долар\Тенге',
'ER_APP_EU_KZ' => 'Пара: Євро\Тенге',

'ER_APP_BANK_BY' => 'Курс Нац Банку Республіки Беларусь',
'ER_APP_DO_BY' => 'Пара: Долар\Белоруський рубль',
'ER_APP_EU_BY' => 'Пара: Євро\Белоруський рубль',


/* end module names */
);

foreach ($dictionary as $k=>$v)
{
   if (!defined('LANG_' . $k))
   {
      define('LANG_' . $k, $v);
   }
}

?>
