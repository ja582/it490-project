#!/bin/bash
read -p "Which subdirectory, rmq or web?" sub

read -p "Which file would you like reverted?" revert

sudo rm /var/www/html/it490-project/$sub/$revert && echo "file successfully removed" || echo "no such file exits"

sudo mv backup/$revert /var/www/html/it490-project/$sub/ && echo "file moved from backup to live directory" || echo "no such file exists"
