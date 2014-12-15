; zone file for <?=$domain['name']?> zone
;
$TTL    86400
;$ORIGIN <?=$domain['name']?>.
@   IN  SOA ns.<?=$names['nameserver']?>. root.<?=$names['nameserver']?>. (
            <?=time()?>     ; Serial
            604800          ; Refresh
            86400           ; Retry
            2419200         ; Expire
            86400 )         ; Negative Cache TTL
;
@       IN      NS      ns.<?=$names['nameserver']?>.
@       IN      A       <?=$domain['ip']?>

ns      IN      A       <?=$names['nameserver_ip']?>

;
www     IN      CNAME   @
<?foreach($records as $record):?>
<?=$record['name']?>    IN  <?=RecordDB::$types[$record['type']]?>   <?=$record['target'].PHP_EOL?>
<?endforeach?>
