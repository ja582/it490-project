#!/bin/bash

read -p "Enter name of file: " file

read -p "Enter IP of destination: " address

read -p "Enter the destination of file: " destination

scp -i /home/ubuntu/.ssh/id_dev_migration $file ubuntu@$address:$destination

echo "file successfully transfered"
