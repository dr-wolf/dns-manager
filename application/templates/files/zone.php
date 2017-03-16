<?foreach($domains as $domain):?>
zone "<?=$domain['name']?>" { type master; file "<?=$path.'db.'.sprintf('%06d', $domain['id'])?>"; };<?=PHP_EOL?>
<?endforeach?>