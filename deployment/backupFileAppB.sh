#!/bin/bash
#located on Machine B. Triggered from script on machine A

read -p "Enter file to copy" copy

cd /var/www/html/it490-project/web/
cp $copy /home/ubuntu/backup/
cd

exit
