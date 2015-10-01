<div style="margin: 10px 0px">
    <a class="button" href="/add">CREATE DOMAIN</a> 
</div>
<table>
    <thead>
        <tr>
            <td><a href="/?order=id">ID</a></td>
            <td><a href="/?order=name">Domain</a></td>
            <td><a href="/?order=ip">IP</a></td>
            <td><a href="/?order=mailserver">Mail</a></td>
            <td><a href="/?order=modified">Status</a></td>
            <td class="button-column"></td>
            <td class="button-column"></td>
        </tr>
    </thead>
    <?foreach($domains as $domain):?>
        <tr>
            <td><?=$domain['id']?></td>
            <td><a href="/<?=$domain['id']?>"><?=$domain['name']?></a></td>
            <td><?=$domain['ip']?></td>
            <td><?=$domain['mailserver'] ? "YES" : "NO"?></td>
            <td><?=$domain['modified'] ? "UPDATED" : "STABLE"?></td>
            <td class="button-column"><a class="button" href="/<?=$domain['id']?>/edit">edit</a></td>
            <td class="button-column"><a class="button" href="/<?=$domain['id']?>/delete" onclick="return confirm('Delete this domain?')">delete</a></td>
        </tr>
        <?endforeach?>
</table>
