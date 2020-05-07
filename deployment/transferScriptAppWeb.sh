#!/bin/bash


read -p "Enter IP of destination: " address

#used to transfer all app files in web directory.
#client files from rmq folder should be transfered via transferScriptAppFile.sh


scp -i /home/ubuntu/.ssh/id_dev_migration -r /var/www/html/it490-project/web/ ubuntu@$address:/var/www/html/it490-project/ && echo "file successfully transferred" || echo "file transfer failed"


