#!/bin/bash

sudo apt-get install apache2
sudo apt-get install php 
sudo apt-get install php-mbstring
sudo apt-get install composer
sudo apt-get install php-bcmath
composer require php-amqplib/php-amqplib


#going to have to composer install after files are transfered in via scp
