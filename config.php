<?php
if(!defined('IRB_KEY'))
{
   header("HTTP/1.1 404 Not Found");
   exit(file_get_contents('./404.html'));
}

$admins = array(
  'root'  => 'root',
);

define('SUPPORT_EMAIL', 'no-replay@freelancehunt.com');

define('IRB_REWRITE', 'on');

define('IRB_DBSERVER', 'localhost');
define('IRB_DBUSER', '');
define('IRB_DBPASSWORD', '');
define('IRB_DATABASE', '');
define('API_TOKEN', '');



define('IRB_ROOT', str_replace('\\', '/', dirname(__FILE__)));

define('IRB_HOST', 'https://'. $_SERVER['HTTP_HOST'] .'/');

spl_autoload_register(function ($className) {
    $registeredClasses = [
        'Project_Model' => __DIR__ . '/models/project_model.php',
        'Data_Table' => __DIR__ . '/libs/data_table.php',
    ];

    if (array_key_exists($className, $registeredClasses)) {
        require_once $registeredClasses[$className];
    }
});

define('IRB_CONFIG_SALT', 'bou5s@l#mea2d');