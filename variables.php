<?php
if(!defined('IRB_KEY')) {
   header("HTTP/1.1 404 Not Found");
   exit(file_get_contents('./404.html'));
}

function pre($array, $debugIndex = 0) {
    $debug = debug_backtrace();
    echo "<font color=#8a2be2>" . $debug[$debugIndex]["file"] . "</font>:<font color='red'>" . $debug[$debugIndex]["line"];
    echo '<pre>' . print_r($array, 1) . '</pre>';
}

function stripslashesDeep($data) {
    if(is_array($data))
        $data = array_map("stripslashesDeep", $data);
    else
        $data = stripslashes($data);
    return $data;
}

if(get_magic_quotes_gpc()) {
    $_GET = stripslashesDeep($_GET);
    $_POST = stripslashesDeep($_POST);
    $_COOKIE = stripslashesDeep($_COOKIE);
}

$GET = array(
    'page'   => 'main',
    'mod'    => 'read',
    'parent' => 0,
    'id'     => 0,
    'num'    => 1,
);

if(IRB_REWRITE === 'on' && !empty($_GET['route'])) {
    $param = explode('/', trim($_GET['route'], '/'));
    $i = 0;
    foreach($GET as $var => $val) {
        if(!empty($param[$i]))
           $GET[$var] = $param[$i];
        $i++;
    }
}
elseif(!empty($_GET))
{
    foreach($GET as $var => $val)
        if(!empty($_GET[$var]))
           $GET[$var] = $_GET[$var];
}

$POST = array(
    'value1'  =>  '',
    'value2'  =>  '',
    'value3'  =>  '',
    'value4'  =>  '',
    'value5'  =>  '',
    'value6'  =>  '',
    'value7'  =>  '',
    'value8'  =>  '',
    'value9'  =>  '',
    'value10' =>  '',
    'array1'  => array(),
    'array2'  => array(),
);

if(!empty($_POST['form'])){
    $POST = array_merge($POST, $_POST['form']);
}

$info  = array();
$META  = '';









