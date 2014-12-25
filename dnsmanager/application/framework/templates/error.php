<!doctype html>
<html>
    <head>
        <title><?=self::$title?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <style type="text/css">
            body { font-family: sans-serif;}
            div { padding: 20px; margin: 20px;}
        </style>
        <?if(Core::$config['debug']):?>
            <div style="border: 1px solid blue">
                <h1><?=($exception->getCode())?$exception->getCode().':':''?> <?=$exception->getMessage()?></h1>
                <p>in <b><?=$exception->getFile()?></b> (Line <?=$exception->getLine()?>)</p>
            </div>
            <div>
                <h2>Stack trace</h2>
                <ul style="font-family: monospace;">
                    <?foreach($exception->getTrace() as $line):?>
                        <?if(isset($line['file']) && isset($line['line'])):?>
                        <li>at <?=$line['file']?>:<?=$line['line']?></li>
                        <?endif?>
                        <?endforeach?>
                </ul>
            </div>
            <?else:?>
            <div style="border: 1px solid blue; width: 600px; margin: 300px auto; ">
                <h1><?=$exception->getCode()?></h1> 
                <p><?=$exception->getMessage()?></p>
            </div>
            <?endif?>
    </body>
</html>