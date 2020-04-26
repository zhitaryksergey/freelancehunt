<?php
if(!defined('IRB_KEY')) {
   header("HTTP/1.1 404 Not Found");
   exit(file_get_contents('../404.html'));
}

$project = new Project_Model(0,[]);
$data = $project->getChart();

$tpl_main_header   = parseTpl(getTpl('chart/header'), [
    'info'  => IRB_TEXT3,
]);
$tpl_main_main   = parseTpl(getTpl('chart/index'), [
    'chart' => [
        $data->cnt500,
        $data->cnt1000,
        $data->cnt5000,
        $data->cntMore,
    ]
]);

$tpl_main_footer   = parseTpl(getTpl('chart/footer'), [
    'info'  => '',
]);