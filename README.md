dns-manager
===========

Web GUI for bind9 daemon, written on PHP.

Web client stores domains and their A and CNAME record in database. Every 5 minutes cron task checks db for changes and updates zone.conf and db files and restarts bind9 daemon if changes was made.

*WARNING! Webclient has no authentication, so ensure that webclient is not accessed from external network or protect it with apache mod_auth!*