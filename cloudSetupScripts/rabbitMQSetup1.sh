#!/bin/bash

sudo apt install rabbitmq-server

sudo rabbitmqctl add_user projectDev projectDev
sudo rabbitmqctl set_permissions -p / projectDev ".*" ".*" ".*"

sudo rabbitmqctl add_user projectQA projectQA
sudo rabbitmqctl set_permissions -p / projectQA ".*" ".*" ".*"

sudo rabbitmqctl add_user projectProd projectQA
sudo rabbitmqctl set_permissions -p / projectProd ".*" ".*" ".*"
