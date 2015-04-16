#!/usr/bin/env bash

#update and upgrade
sudo apt-get update -y
sudo apt-get upgrade -y

#set password for mysql
PASSWORD='123'

#check if phpfolder already exist and if php is installed
phpfolder=true
phpinstalled=false
files=(/etc/php5/apache2/*)
if [ ${#files[@]} -gt 0 ]
	then 
		phpfolder=false; 
fi
if dpkg-query -W php5
	then
		phpinstalled=true;
fi

#caching php-folder
if [ phpfolder ] && [ phpinstalled ]
  then
	sudo mkdir ~/php-cache
	sudo cp -a /etc/php5/* ~/php-cache
	sudo rm -r /etc/php5/*
fi

#install php with mcrypt
if ! phpinstalled
  then
	sudo apt-get install -y php5
	sudo apt-get install -y php5-mcrypt
fi

#after php is installed set the local files for php
if [ phpfolder ] && [ phpinstalled ]
  then
	sudo cp -a ~/php-cache/apache2/php.ini /etc/php5/apache2
	sudo rm -r ~/php-cache/
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

#change root_dir
if ! grep -q '/var/www/web' "/etc/apache2/sites-available/000-default.conf" 
	then 
		sudo sed -i 's|'var/www/html'|'var/www/application/web'|g' /etc/apache2/sites-available/000-default.conf
fi

#enabling mcrypt if it isn't
if ! grep -q 'extension=mcrypt.so' "/etc/php5/apache2/php.ini" 
	then 
		echo "extension=mcrypt.so" >> /etc/php5/apache2/php.ini
fi

#restart apache2
sudo service apache2 restart -y