<?php
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
global $USER;
if ($USER->IsAdmin()) {
    return [
        [
        'parent_menu' => 'global_menu_content',
        'sort' => 400,
        'text' => Loc::getMessage('WEB_D7_MENU_TITLE'),
        'title' => "",
        'url' => 'web.d7.php'
        ]
    ];
}