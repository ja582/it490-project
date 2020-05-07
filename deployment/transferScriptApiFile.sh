#!/bin/bash


read -p "Enter name of file: " file

read -p "Enter IP of destination: " address

# files needed for the api are only in the rmq directory


scp -i /home/ubuntu/.ssh/id_api_migration /it490-project/rmq/$file ubuntu@$address:/it490-project/rmq/ && echo "file successfully transferred" || echo "file transfer failed"
