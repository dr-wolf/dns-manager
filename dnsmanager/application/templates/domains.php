<table>
    <thead>
        <tr>
            <td><a href="/?order=id">ID</a></td>
            <td><a href="/?order=name">Domain</a></td>
            <td><a href="/?order=ip">IP</a></td>
            <td><a href="/?order=modified">Status</a></td>
            <td class="button-column"></td>
            <td class="button-column"></td>
        </tr>
    </thead>
    <?foreach($domains as $domain):?>
        <tr>
            <td><?=$domain['id']?></td>
            <td><a href="/domain?id=<?=$domain['id']?>"><?=$domain['name']?></a></td>
            <td><?=$domain['ip']?></td>
            <td><?=$domain['modified'] ? "UPDATED" : "STABLE"?></td>
            <td class="button-column"><a class="button" href="/edit?id=<?=$domain['id']?>">edit</a></td>
            <td class="button-column"><a class="button" href="/delete?id=<?=$domain['id']?>" onclick="return confirm('Delete this domain?')">delete</a></td>
        </tr>
        <?endforeach?>
</table>