#!/bin/bash

sudo apt-get install apache2
sudo apt-get install git
sudo apt-get install php 
sudo apt-get install php-mbstring
sudo apt-get install composer
sudo apt-get install php-bcmath
composer require php-amqplib/php-amqplib


cd /var/www/html
git clone https://github.com/ja582/it490-project.git
cd it490-project
cd rmq
composer install
