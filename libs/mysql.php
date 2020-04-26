<?php

if(!defined('IRB_KEY'))
{
   header("HTTP/1.1 404 Not Found");
   exit(file_get_contents('../404.html'));
}

class DB
{
    static $link;
    static $count = 0; 
    
    public static function conhect()
    {
        self::$link = mysqli_connect(IRB_DBSERVER, IRB_DBUSER, IRB_DBPASSWORD, IRB_DATABASE) 
                       or die('No connect'); 
        
        mysqli_set_charset(self::$link, 'utf8');    
    }
}


function escapeString($data)
{
    if(!isset(DB::$link))
        DB::conhect();

    if(is_array($data))
        $data = array_map("escapeString", $data);
    else
        $data = mysqli_real_escape_string(DB::$link, $data);

    return $data;
}

function mysqlQuery($sql, $print = false)
{
    if(!isset(DB::$link))
        DB::conhect();

    DB::$count++;

    $result = mysqli_query(DB::$link, $sql);

    if($result === false || $print)
    {
        $error =  mysqli_error(DB::$link);
        $trace =  debug_backtrace();

        $head = !empty($error) ?'<b style="color:red">MySQL error: </b><br> 
        <b style="color:green">'. $error .'</b><br><br>':NULL;

        $error_log = date("Y-m-d h:i:s") .' '. $head .' 
        <b>Query: </b><br> 
        <pre><span style="color:#CC0000">'. $trace[0]['args'][0] .'</pre></span><br><br>
        <b>File: </b><b style="color:#660099">'. $trace[0]['file'] .'</b><br> 
        <b>Line: </b><b style="color:#660099">'. $trace[0]['line'] .'</b>';

/** 
* @TODO To clean in release 
*/ 
//----------------------------- 
       die($error_log);
//-----------------------------

        file_put_contents(IRB_ROOT .'log/mysql.log', strip_tags($error_log) ."\n\n", FILE_APPEND);
        header("HTTP/1.1 404 Not Found");
        die(file_get_contents(IRB_ROOT .'/404.html'));
    }
    else
        return $result;
}
       




    
    
    
    
    