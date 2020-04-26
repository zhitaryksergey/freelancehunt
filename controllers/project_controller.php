<?php
if(!defined('IRB_KEY')) {
   header("HTTP/1.1 404 Not Found");
   exit(file_get_contents('../404.html'));
}

if($GET['mod'] == 'ajax') {

    $table = 'Projects';

    $primaryKey = 'id';

    $columns = [
        ['db' => 'id', 'dt' => 'id'],
        ['db' => 'name', 'dt' => 'name'],
        ['db' => 'description', 'dt' => 'description'],
        ['db' => 'link', 'dt' => 'link'],
        ['db' => 'budget', 'dt' => 'budget'],
        ['db' => 'currency', 'dt' => 'currency'],
        ['db' => 'first_name', 'dt' => 'first_name'],
        ['db' => 'last_name', 'dt' => 'last_name'],
        ['db' => 'login', 'dt' => 'login'],
    ];

    echo json_encode(Data_Table::simple($_POST, $table, $primaryKey, $columns));
} else {

    set_time_limit(0);

    $project = new Project_Model(1, [1,99,86]);

    $project->cleanTable();

    $boolean = true;
    while($boolean) {
        $data = $project->getProjects();
        if (isset($data->data) && !empty($data->data)) {
            $projects = [];
            foreach ($data->data as $info) {
                if (isset($info->id) && $info->id) {
                    $budget_info = $project->getBudget($info->id);
                    $price = isset($project->Privat[$budget_info->data->attributes->budget->currency]) ?
                        $project->Privat[$budget_info->data->attributes->budget->currency]['buy'] * $budget_info->data->attributes->budget->amount : $budget_info->data->attributes->budget->amount;
                    $projects[] =
                        "(" .
                        (int)$info->id . ',' .
                        "'" . escapeString($info->attributes->name) . "'," .
                        "'" . escapeString($info->attributes->description) . "'," .
                        "'" . escapeString($info->links->self->web) . "'," .
                        (int)$price . "," .
                        (int)$budget_info->data->attributes->budget->amount . "," .
                        "'" . escapeString($budget_info->data->attributes->budget->currency) . "'," .
                        "'" . escapeString($info->attributes->employer->first_name) . "'," .
                        "'" . escapeString($info->attributes->employer->last_name) . "'," .
                        "'" . escapeString($info->attributes->employer->login) . "'" .
                        ")";
                    sleep(rand(1, 3));
                }
            }
            if (!empty($projects)) {
                $project->saveData($projects);
            }

            if (isset($data->links, $data->links->next)) {
                $output = [];
                $params = parse_url($data->links->next);
                parse_str($params['query'], $output);
                if($output['page']['number']) {
                    $project->setPage($output['page']['number']);
                } else {
                    $boolean = false;
                }
            } else {
                $boolean = false;
            }
            sleep(rand(1, 3));
        }
    }

    $tpl_main_header   = parseTpl(getTpl('cron/header'), [
        'info'  => IRB_TEXT1,
    ]);
    $tpl_main_main     = '';
    $tpl_main_footer   = '';
}

