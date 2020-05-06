#!/bin/bash

sudo apt install php
sudo apt install curl
sudo apt install git
sudo apt install php-mbstring
sudo apt install composer
sudo apt install php-bcmath
composer require php-amqplib/php-amqplib

git clone https://github.com/ja582/it490-project.git
cd it490-project
cd rmq
composer install
