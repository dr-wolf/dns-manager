# Install guide

1. Create a MySQL database and user;
2. Import `database.sql` dump;
3. Copy content of `dnsmanager` folder to `/var/www` for example and configure apache to point to `public_html` directory;
4. Edit `application/config.json` and set the correct db credentials, your nameserver FQDN, external ip and set path to zone.conf file and db directory, where db files will be stored;
5. Include zone.conf into your named.conf file;
6. Execute `chmod +x application/cron.php`;
7. Add new cron task `/path/to/application/cron.php -c processqueue` with interval 5 minutes;

Make sure you have enabled short tags (`short_open_tag` must be On). Also you need to enable it in both php.ini files for apache and for cli, as cron task also uses short tags.

*WARNING! Webclient has no authentication, so ensure that webclient is not accessed from external network or protect it with apache mod_auth!*
