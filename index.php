<?php
header("Content-Type: text/html; charset=utf-8");
error_reporting(E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

session_start();
ob_start();

define('IRB_KEY', true);

include './config.php';
include IRB_ROOT .'/variables.php';
include IRB_ROOT .'/language/ru.php';
include IRB_ROOT .'/libs/mysql.php';
include IRB_ROOT .'/libs/default.php';
include IRB_ROOT .'/libs/view.php';

switch($GET['page']) {

    case 'chart' :
        $title       = 'Активные проекты';
        $keywords    = 'Активные проекты';
        $description = 'Активные проекты';
        include IRB_ROOT .'/controllers/chart_controller.php';
    break;
    case 'cron' :
        include IRB_ROOT .'/controllers/project_controller.php';
    break;
    default :
        $title       = 'Активные проекты';
        $keywords    = 'Активные проекты';
        $description = 'Активные проекты';
        include IRB_ROOT .'/controllers/main_controller.php';
    break;
}

$content = ob_get_clean();

include IRB_ROOT .'/skins/tpl/index.php';