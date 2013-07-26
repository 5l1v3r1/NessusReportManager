#!/bin/bash
#
# Mehmet Dursun INCE
# Detecting and Parsing "top" command for gettin CPU USAGE
#
echo $(top -bn1 | grep "Cpu(s)" | sed "s/.*, *\([0-9.]*\)%\id.*/\1/" | awk '{print "%"100 - $1" Used"}')