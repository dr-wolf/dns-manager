<div>Domain: <?=$domain['name']?></div>
<div>IP: <?=$domain['ip']?></div>
<div>Mail server: <?=$domain['mailserver'] ? 'YES' : 'NO'?></div>
<div>State: <?=$domain['modified'] ? 'UPDATED' : 'STABLE'?></div>
<div style="margin: 10px 0px">
    <a class="button" href="/<?=$domain['id']?>/edit">EDIT</a> ::
    <a class="button" href="/<?=$domain['id']?>/addrec">CREATE RECORD</a> :: 
    <a class="button" href="/<?=$domain['id']?>/adduser">CREATE USER</a> :: 
    <a class="button" href="/<?=$domain['id']?>/raw">VIEW DB</a>    
</div>
<div>Subdomains:</div>
<table border="1">
    <thead>
        <tr>
            <td><a href="/domain?id=<?=$domain['id']?>&order=name">Name</a></td>
            <td><a href="/domain?id=<?=$domain['id']?>&order=type">Type</a></td>
            <td><a href="/domain?id=<?=$domain['id']?>&order=target">Target</a></td>
            <td class="button-column"></td>
            <td class="button-column"></td>
        </tr>
    </thead>
    <?foreach($records as $record):?>
        <tr>
            <td><?=$record['name']?></td>
            <td><?=RecordDB::$types[$record['type']]?></td>
            <td><?=$record['target']?></td>
            <td class="button-column"><a class="button" href="/<?=$domain['id']?>/<?=$record['id']?>/editrec">edit</a></td>
            <td class="button-column"><a class="button" href="/<?=$domain['id']?>/<?=$record['id']?>/deleterec" onclick="return confirm('Delete this record?')">delete</a></td>
        </tr>
        <?endforeach?>
</table>
<div style="margin-top: 20px;">Users mail accounts:</div>
<table border="1">
    <thead>
        <tr>
            <td>Login</td>
            <td class="button-column"></td>
            <td class="button-column"></td>
        </tr>
    </thead>
    <?foreach($users as $user):?>
        <tr>
            <td><?=$user['login'].'@'.$domain['name']?></td>
            <td class="button-column"><a class="button" href="/<?=$domain['id']?>/<?=$user['id']?>/edituser">edit</a></td>
            <td class="button-column"><a class="button" href="/<?=$domain['id']?>/<?=$user['id']?>/deleteuser" onclick="return confirm('Delete this user account?')">delete</a></td>
        </tr>
        <?endforeach?>
</table>