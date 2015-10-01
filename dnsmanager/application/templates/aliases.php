<div style="margin: 10px 0px">
    <a class="button" href="/aliases/add">CREATE REDIRECTION</a> 
</div>
<table border="1">
    <thead>
        <tr>
            <td><a href="/aliases?order=id">ID</a></td>
            <td><a href="/aliases?order=email">Email</a></td>
            <td><a href="/aliases?order=destination">Destination</a></td>
            <td class="button-column"></td>
            <td class="button-column"></td>
        </tr>
    </thead>
    <?foreach($aliases as $alias):?>
        <tr>
            <td><?=$alias['id']?></td>
            <td><?=$alias['email']?></td>
            <td><?=$alias['destination']?></td>
            <td class="button-column"><a class="button" href="/aliases/<?=$alias['id']?>/edit">edit</a></td>
            <td class="button-column"><a class="button" href="/aliases/<?=$alias['id']?>/delete" onclick="return confirm('Delete this record?')">delete</a></td>
        </tr>
        <?endforeach?>
</table>
