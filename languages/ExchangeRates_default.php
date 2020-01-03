<?php
/**
 * Russian language file for ExchangeRates module
 *
 * @package ExchangeRates
 * @author Alex Sokolov <admin@gelezako.com> http://blog.gelezako.com
 * @version 1.0
 *
 **/

$dictionary = array(
/* general */
'ER_SCRIPT_NAME'=>'Название сценария',
'ER_APP_ABOUT' => 'Про модуль',
'ER_APP_CLOSE' => 'Закрыть',
'ER_APP_MODULE' => 'Модуль',
'ER_APP_PROJ' => 'Проект в',
'ER_APP_DONATE' => 'Поддержать разработку и развитие модуля:',
'ER_APP_DONATE2' => 'Страничка для доната в',
'ER_APP_DONATE3' => 'Внутренний счет в',
'ER_APP_Author' => 'Автор',
'ER_APP_NAME' => 'Курс валют',
'ER_APP_TITLE' => 'Выберите тип валюты,<br>который хотите получить',
'ER_APP_BANK_UA' => 'Коммерческий курс ПриватБанка',
'ER_APP_NOTIF' => 'Невозможно получить курс валют ПриватБанка',
'ER_APP_NOTIF2' => 'Невозможно получить курс валют Банка России',
'ER_APP_NOTIF3' => 'Невозможно получить курс валют НБУ',
'ER_APP_NOTIF4' => 'Невозможно получить курс валют Нац Банка Казахстана',
'ER_APP_NOTIF5' => 'Невозможно получить курс валют Нац Банка Республики Беларусь',

//Пары валют
'ER_APP_EU_HR' => 'Пара: Евро\Гривна',
'ER_APP_DO_HR' => 'Пара: Доллар\Гривна',
'ER_APP_RU_HR' => 'Пара: Рубль\Гривна',

'ER_APP_BANK_RU' => 'Курс Банка России',
'ER_APP_DO_RU' => 'Пара: Доллар\Рубль',
'ER_APP_EU_RU' => 'Пара: Евро\Рубль',

'ER_APP_BANK_NBU' => 'Курс НБУ',
'ER_APP_SOUND' => 'Озвучить',
'ER_APP_DISCUS' => 'обсуждение модуля на форуме',
'ER_APP_INFO' => 'Курс НБУ предоставлен порталом',
'ER_APP_MINFIN' => 'Минфин.',

'ER_APP_BANK_KZ' => 'Курс Нац Банка Казахстана',
'ER_APP_DO_KZ' => 'Пара: Доллар\Тенге',
'ER_APP_EU_KZ' => 'Пара: Евро\Тенге',

'ER_APP_BANK_BY' => 'Курс Нац Банка Республики Беларусь',
'ER_APP_DO_BY' => 'Пара: Доллар\Белорусский рубль',
'ER_APP_EU_BY' => 'Пара: Евро\Белорусский рубль',




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
