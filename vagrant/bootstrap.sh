#!/usr/bin/env bash

#update and upgrade
sudo apt-get update -y
sudo apt-get upgrade -y

#set password for mysql
PASSWORD='123'

#check if phpfolder already exist and if php is installed
phpfolder=false
phpinstalled=false
files=/etc/php5/apache2/*
if [ ${#files[@]} -gt 0 ]
	then 
		phpfolder=true; 
fi
if dpkg-query -W php5
	then
		phpinstalled=true;
fi

#caching php-folder
if $phpfolder && ! $phpinstalled
  then
	sudo mkdir ~/php-cache
	sudo cp -r /etc/php5/* ~/php-cache
	sudo rm -r /etc/php5/*
fi

#install php with extensions
if ! $phpinstalled
  then
	sudo apt-get install -y php5
	sudo apt-get install -y php5-mcrypt
	sudo apt-get install -y php5-xdebug
fi

#after php is installed set the local files for php
if $phpfolder && ! $phpinstalled
  then
	sudo cp -r ~/php-cache/apache2/php.ini /etc/php5/apache2/php.ini
fi

#install mysql
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password $PASSWORD"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $PASSWORD"
sudo apt-get -y install mysql-server
sudo apt-get -y install php5-mysql

#install phpmyadmin
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/dbconfig-install boolean true"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/app-password-confirm password $PASSWORD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/admin-pass password $PASSWORD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/app-pass password $PASSWORD"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2"
sudo apt-get -y install phpmyadmin

#enabling mod_rewrite
sudo a2enmod rewrite

#setup hosts file
VHOST=$(cat <<EOF
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/application/web
        <Directory "/var/www/application/web">
                AllowOverride All
                Require all granted
        </Directory>
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
# vim: syntax=apache ts=4 sw=4 sts=4 sr noet
EOF
)
if ! grep -q '/var/www/web' "/etc/apache2/sites-available/000-default.conf" 
	then
		#!/bin/sh
		echo "${VHOST}" > /etc/apache2/sites-available/000-default.conf
fi

#enabling extensions
if ! $phpfolder
	then
		#mcrypt
		echo "extension=mcrypt.so" >> /etc/php5/apache2/php.ini;
		
		#xdebug
		echo ";xdebug
		zend_extension=\"/usr/lib/php5/20100525/xdebug.so\"
		xdebug.remote_enable=1
		xdebug.remote_handler=dbgp xdebug.remote_mode=req
		xdebug.remote_host=127.0.0.1 xdebug.remote_port=9000" >> /etc/php5/apache2/php.ini;
fi

#restart apache2
sudo service apache2 restart -y