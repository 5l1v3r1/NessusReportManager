#!/bin/bash
#
# Detecting Interfaces names and IpAddress
#
setuid 0
for i in $(netstat -i|awk '{print $1}'|grep -v -i 'kernel\|Iface'); 
do 
    IP=$(ifconfig $i|grep 'inet addr:' | cut -d: -f2|cut -d' ' -f1)
    echo $IP
done
