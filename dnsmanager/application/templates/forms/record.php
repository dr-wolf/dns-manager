<div style="margin: 10px 0px">
    <a class="button" href="/<?=$record['domain_id']?>">GO BACK</a>    
</div>
<form method="post" name="record">
    <div>
        <div class="col label"><label for="record[name]">Domain name:</label></div>
        <div class="col"><input type="text" name="record[name]" value="<?=$record['name']?>"/></div>
    </div>
    <div>
        <div class="col label"><label for="record[type]">Type:</label></div>
        <div class="col">
            <select name="record[type]">
                <?foreach(RecordDB::$types as $id => $type):?>
                    <option value="<?=$id?>" <?=($id == $record['type']?"selected":"")?>><?=$type?></option>
                    <?endforeach?>
            </select>
        </div>
    </div>
    <div>
        <div class="col label"><label for="record[target]">Target:</label></div>
        <div class="col"><input type="text" name="record[target]" value="<?=$record['target']?>"/></div>
    </div>
    <input type="hidden" name="record[domain_id]" value="<?=$record['domain_id']?>">
    <input type="hidden" name="record[id]" value="<?=$record['id']?>">
    <div class="row"><input type="submit" value="Send"></div> 
    <div class="error"><?=$error?></div>
</form>


