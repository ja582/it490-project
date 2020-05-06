#!/bin/bash

sudo apt install php
sudo apt install curl
sudo apt install php-curl
sudo apt install php-mbstring
sudo apt install composer
sudo apt install php-bcmath
composer require php-amqplib/php-amqplib

#going to have to composer install in rmq folder after files are transfered in via scp
