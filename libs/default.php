<?php
if(!defined('IRB_KEY')) {
   header("HTTP/1.1 404 Not Found");
   exit(file_get_contents('../404.html'));
}

function href() {
    global $GET;
    $tmp = $GET;
    $href = '';
    $host = IRB_HOST;
    $arg = func_get_args();
    if(defined('IRB_ADMIN'))
        $host .= 'admin/';

    if($arg[0] == 'host')
        return IRB_HOST;

    if(is_array($arg[0]))
        $arg = $arg[0];

    foreach($arg as $var)
    {
        $param = explode('=', $var);

        if(array_key_exists($param[0], $tmp))
            $tmp[$param[0]] = $param[1];
        else
            die('The variable <b>'. $param[0] .'</b> is not defined');
    }

    $cnt = array_flip(array_keys($tmp));
    $tmp = array_slice($tmp, 0, $cnt[$param[0]] + 1);

    foreach($tmp as $var => $val)
        if(IRB_REWRITE === 'on')
            $href .= '/'. $val;
        elseif(!empty($val))
            $href .= '&'. $var .'='. $val;

    if(IRB_REWRITE === 'on')
        return $host . hrefTrim($href);
    else
        return $host .'?'. trim($href, '&');
}

function hrefTrim($link) {
    return preg_replace('#(/0)+$#', '', ltrim($link, '/'));
}

function __autoload($classname) {
    global $INCLUDE_PATCH;
    foreach ($INCLUDE_PATCH as $include_path) {
        $class = IRB_ROOT .'/'. $include_path .'/'. strtolower($classname) .'.php';
        if(file_exists($class)) {
            include_once $class;
            break;
        }
    }
}

function reDirect() {
    $arguments = func_get_args();

    if(count($arguments))
        header('location: '. href($arguments));
    else
        header('location: '. str_replace("/index.php", "", $_SERVER['HTTP_REFERER']));
    exit();
}

function returnCheck($id, $return)
{
   return ($id == $return) ? 'checked="checked"' : NULL;
}

function returnSelect($id, $return)
{
   return ($id == $return) ? 'selected="selected"' : NULL;
}

function randStr($len = 10)
{
    $arr = array_merge(range('#', '&'), range(0, 9), range('a', 'z'));
    shuffle($arr);
    return implode('', array_slice($arr, 0, $len));
}

function unsignet($number)
{
    return ($number > 0) ? $number : 0;
}

function emptyfilter($val)
{
    return (bool)$val;
}