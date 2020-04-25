#!/bin/bash

sudo apt install rabbitmq-server

sudo rabbitmqctl add_user projectDev
sudo rabbitmqctl set_permissions -p / projectDev ".*" ".*" ".*"

sudo rabbitmqctl add_user projectQA
sudo rabbitmqctl set_permissions -p / projectQA ".*" ".*" ".*"

sudo rabbitmqctl add_user projectProd
sudo rabbitmqctl set_permissions -p / projectProd ".*" ".*" ".*"
