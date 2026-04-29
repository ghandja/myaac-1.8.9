@echo off
set PHP_SELECT=php82
set PHP_INI_SELECT=php82
set US_ROOTF=C:/Users/Usuario/Documents/UniServerZ
set US_ROOTF_WWW=C:/Users/Usuario/Documents/UniServerZ/www
set US_SERVERNAME=localhost
set AP_PORT=80
set AP_SSL_PORT=443

C:\Users\Usuario\Documents\UniServerZ\core\apache2\bin\httpd_z.exe -f C:/Users/Usuario/Documents/UniServerZ/core/apache2/conf/httpd.conf
