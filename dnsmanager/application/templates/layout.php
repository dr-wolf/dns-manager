<!doctype html>
<html>
    <head>
        <title><?=self::$title?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="/css/style.css" />
    </head>
    <body>
        <div class="page">
            <div class="header">
                <div class="info">Cron timeout: <?=date("i:s", 300 - (time() % 300))?></div>
                <?=self::$title?>
            </div>
            <div class="menu">
                <a class="button" href="/">DOMAINS</a> ::
                <a class="button" href="/add">ADD DOMAIN</a> :: 
                <a class="button" href="/urls">URL TREE</a>  
            </div>
            <div class="content">
                <?=$content?>
            </div>
            <div class="footer">
                &copy; ENIGMA Development Laboratory, 2014
            </div>
        </div>
    </body>
</html>