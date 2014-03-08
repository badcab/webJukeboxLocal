#!/bin/bash

echo 'deb http://www.deb-multimedia.org wheezy main non-free' >> /etc/apt/sources.list

apt-get update

apt-get -y --force-yes install deb-multimedia-keyring
#to to then tell the sytem to use this key ring

apt-get -y upgrade

ssh-keygen -t rsa

addgroup --system www-data
adduser www-data www-data

apt-get -y install lighttpd mysql-server php5-cgi php5-mysql php5-cli git
#likely have to add the requirements to install m4a playback and tag reading

usermod -a -G www-data www-data
usermod -a -G www-data pi
chown -R www-data:www-data /var/www
chgrp -R www-data /var/www
chmod -R g+w /var/www

find /var/www -type d -exec chmod 2775 {} \;
find /var/www -type f -exec chmod ug+rw {} \;

wget https://packages.zendframework.com/releases/ZendFramework-1.12.3/ZendFramework-1.12.3.zip /var/www
wget https://github.com/JamesHeinrich/getID3/archive/1.9.7.zip /var/www
wget https://github.com/twbs/bootstrap/releases/download/v3.1.1/bootstrap-3.1.1-dist.zip /var/www
wget http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.0.min.js /var/www

unzip /var/www/ZendFramework-1.12.3.zip
unzip /var/www/getID3-1.9.7.zip
unzip /var/www/bootstrap-3.1.1-dist.zip

mysql -u root -p

#might get an ssh type error, consider making this a fork or something
git clone git@github.com:badcab/webJukeboxLocal.git

sed -i 's/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=1/g' /etc/php5/cgi/php.ini
echo 'server.modules += ("mod_cgi")' >> /etc/lighttpd/conf-enabled/10-cgi-php.conf
echo ' cgi.assign = (".php" => "/usr/bin/php5-cgi")' >> /etc/lighttpd/conf-enabled/10-cgi-php.conf

/etc/init.d/lighttpd force-reload

lighty-enable-mod fastcgi-php

/etc/init.d/lighttpd force-reload

#run the sql file in /var/www/webJukeboxLocal/db_setup.sql

chown -R www-data:www-data /var/www

