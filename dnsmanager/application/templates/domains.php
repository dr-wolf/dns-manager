<table>
    <thead>
        <tr>
            <td>ID</td>
            <td>Domain</td>
            <td>IP</td>
            <td>Status</td>
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