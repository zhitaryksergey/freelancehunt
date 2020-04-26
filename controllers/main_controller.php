<?php
if(!defined('IRB_KEY')) {
   header("HTTP/1.1 404 Not Found");
   exit(file_get_contents('../404.html'));
}

$tpl_main_header   = parseTpl(getTpl('main/header'), [
    'info'  => IRB_TEXT2,
]);

$tpl_main_main   = parseTpl(getTpl('main/index'), []);

$tpl_main_footer   = parseTpl(getTpl('main/footer'), [
    'info'  => '',
]);