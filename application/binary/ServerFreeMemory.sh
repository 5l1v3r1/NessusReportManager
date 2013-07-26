#!/bin/bash
#
# Mehmet Dursun INCE
# Detecting and Parsing "free" command for gettin RAM Usage
#
USEDMEMORY=$(free|grep -i 'mem'|awk '{print $2}')
FREEMEMORY=$(free|grep -i 'mem'|awk '{print $3}')

echo "%"$(( ($FREEMEMORY * 100)/$USEDMEMORY ))" Used"