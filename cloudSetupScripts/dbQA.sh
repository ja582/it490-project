#!/bin/bash

sudo apt install php
sudo apt install php-mysqli
sudo apt install php-mbstring
sudo apt install php7.2-sqlite
sudo apt install composer
sudo apt install php-bcmath
composer require php-amqplib/php-amqplib

#going to have to composer install in rmq folder after files are transfered in via scp
