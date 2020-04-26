<?php
if(!defined('IRB_KEY')) {
    header("HTTP/1.1 404 Not Found");
    exit(file_get_contents('../404.html'));
}

define('IRB_TEXT1',   'Скрипт завершил работу');
define('IRB_TEXT2',   'Таблица активных проектов');
define('IRB_TEXT3',   'Распределение проектов по бюджету');


