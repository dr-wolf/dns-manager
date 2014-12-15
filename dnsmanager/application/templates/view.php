<div>Domain: <?=$domain['name']?></div>
<div>IP: <?=$domain['ip']?></div>
<div style="margin: 10px 0px">
    <a class="button" href="/edit?id=<?=$domain['id']?>">EDIT</a> ::
    <a class="button" href="/record/add?domain=<?=$domain['id']?>">CREATE RECORD</a> :: 
    <a class="button" href="/domain/zone?id=<?=$domain['id']?>">VIEW DB</a>    
</div>
<table border=1>
    <thead>
        <tr>
            <td>Name</td>
            <td>Type</td>
            <td>Target</td>
            <td class="button-column"></td>
            <td class="button-column"></td>
        </tr>
    </thead>
    <?foreach($records as $record):?>
        <tr>
            <td><?=$record['name']?></a></td>
            <td><?=RecordDB::$types[$record['type']]?></td>
            <td><?=$record['target']?></td>
            <td class="button-column"><a class="button" href="/record/edit?id=<?=$record['id']?>">edit</a></td>
            <td class="button-column"><a class="button" href="/record/delete?id=<?=$record['id']?>&domain=<?=$domain['id']?>" onclick="return confirm('Delete this record?')">delete</a></td>
        </tr>
        <?endforeach?>
</table>