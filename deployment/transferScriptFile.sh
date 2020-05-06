#!/bin/bash
read -p "source rmq or web subdirectory? " sourceSub

read -p "Enter name of file: " file

read -p "Enter IP of destination: " address

read -p "destination rmq or web subdirectory? " destSub


scp -i /home/ubuntu/.ssh/id_dev_migration /var/www/html/it490-project/$sourceSub/$file ubuntu@$address:/var/www/html/it490-project/$destSub/
echo "file successfully transfered"
