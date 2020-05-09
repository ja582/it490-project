#!/bin/bash


read -p "Which file would you like reverted?" revert

sudo rm /it490-project/rmq/$revert && echo "file successfully removed" || echo "no such file exits"

sudo mv backup/$revert /it490-project/rmq/ && echo "file moved from backup to live directory" || echo "no such file exists"
