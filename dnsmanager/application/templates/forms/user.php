<div style="margin: 10px 0px">
    <a class="button" href="/<?=$user['domain_id']?>">GO BACK</a>    
</div>
<form method="post" name="user">
    <div>
        <div class="col label"><label for="user[login]">Login:</label></div>
        <div class="col"><input type="text" name="user[login]" value="<?=$user['login']?>"/></div>
    </div>    
    <div>
        <div class="col label"><label for="user[password]">Password:</label></div>
        <div class="col"><input type="password" name="user[password]"/></div>
    </div>
    <div>
        <div class="col label"><label for="user[password_retype]">Retype password:</label></div>
        <div class="col"><input type="password" name="user[password_retype]"/></div>
    </div>
    <input type="hidden" name="user[domain_id]" value="<?=$user['domain_id']?>">
    <input type="hidden" name="user[id]" value="<?=$user['id']?>">
    <div class="row"><input type="submit" value="Send"></div> 
    <div class="error"><?=$error?></div>
</form>


