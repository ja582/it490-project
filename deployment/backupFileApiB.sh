#!/bin/bash
#located on Machine B. Triggered from script on machine A

read -p "Enter file to copy" copy

cd it490-project/rmq/
cp $copy /home/ubuntu/backup/
cd

exit
