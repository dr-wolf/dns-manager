<form method="post" name="domain">
    <input type="hidden" name="domain[mailserver]" value="0">
    <div>
        <div class="col label"><label for="domain[name]">Domain name:</label></div>
        <div class="col"><input type="text" name="domain[name]" value="<?=$domain['name']?>"/></div>
    </div>
    <div>
        <div class="col label"><label for="domain[ip]">IP address:</label></div>
        <div class="col"><input type="text" name="domain[ip]" value="<?=$domain['ip']?>" /></div>
    </div>
    <div>
        <div class="col label"><label for="domain[mailserver]">Mail server:</label></div>
        <div class="col"><input type="checkbox" name="domain[mailserver]" value="1" <?=$domain['mailserver'] ? 'checked="true"' : ''?> /></div>
    </div>
    <input type="hidden" name="domain[id]" value="<?=$domain['id']?>">
    <div class="row"><input type="submit" value="Send"></div> 
    <div class="error"><?=$error?></div>
</form>



