#!/bin/bash

sudo apt install rabbitmq-server

sudo rabbitmqctl add_user project
sudo rabbitmqctl set_permissions -p / project ".*" ".*" ".*"

