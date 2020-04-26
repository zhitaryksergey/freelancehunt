<?php
session_start();
header('Content-type: text/html; charset=utf-8');
define('IRB_KEY', true);
chdir('..');
include './config.php';
include IRB_ROOT .'/variables.php';
include IRB_ROOT .'/language/ru.php';
include IRB_ROOT .'/libs/mysql.php';
include IRB_ROOT .'/libs/default.php';
include IRB_ROOT .'/libs/view.php';



switch($GET['page']) {
    case 'project' :
        include IRB_ROOT .'/controllers/project_controller.php';
    break;
    default :
        include IRB_ROOT .'/controllers/main_controller.php';
    break;
}