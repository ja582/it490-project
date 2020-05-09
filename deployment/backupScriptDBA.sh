#!/bin/bash
#This is run on machine A. triggers script in machine B which copies file to directory called "backup"

read -p "Enter IP of destination: " address


ssh -i /home/ubuntu/.ssh/id_dev_migration ubuntu@$address "./backupFileDBB.sh"



./transferScriptDBFile.sh
