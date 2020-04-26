<!doctype html>
<html lang="uk">
    <head>
        <title><?=$title?></title>
        <meta name="description" content="<?=$description?>">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="format-detection" content="telephone=no">
        <meta name="author" content="">
        <base href="<?=IRB_HOST?>">
        <link href="skins/css/main.css?version=1.2.1" rel="stylesheet">
    </head>
    <body>
        <div class="mobile-menu-wrap"></div>
        <header>
            <?=$tpl_main_header?>
        </header>
        <main>
            <?=$tpl_main_main?>
        </main>
        <footer class="footer">
            <?=$tpl_main_footer?>
        </footer>
    </body>
</html>