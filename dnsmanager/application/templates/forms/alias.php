<div style="margin: 10px 0px">
    <a class="button" href="/aliases">GO BACK</a>    
</div>
<form method="post" name="alias">
    <div>
        <div class="col label"><label for="alias[source_id]">Email:</label></div>
        <div class="col">
            <select name="alias[source_id]">
                <option value="0">Select email</option>
                <?foreach($emails as $email):?>
                    <option value="<?=$email['id']?>" <?=$email['id'] == $alias['source_id'] ? 'selected' : ''?>><?=$email['email']?></option>
                <?endforeach?>
            </select>    
        </div>
    </div>    
    <div>
        <div class="col label"><label for="alias[destination]">Destination:</label></div>
        <div class="col"><input type="text" name="alias[destination]" value="<?=$alias['destination']?>" style="width: 164px"/></div>
    </div>
    <input type="hidden" name="alias[id]" value="<?=$alias['id']?>">
    <div class="row"><input type="submit" value="Send"></div> 
    <div class="error"><?=$error?></div>
</form>


