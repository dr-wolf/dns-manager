<ul>
    <?foreach($domains as $domain):?>
        <li>
            <a href="http://<?=$domain['name']?>"><?=$domain['name']?></a>
            <?if(isset($domain['records'])):?>
                <ul>
                    <?foreach($domain['records'] as $record):?>   
                        <li><a href="http://<?=$record['name'].'.'.$domain['name']?>"><?=$record['name'].'.'.$domain['name']?></a></li>
                        <?endforeach?> 
                </ul>
                <?endif?>
        </li>
        <?endforeach?>
</ul>