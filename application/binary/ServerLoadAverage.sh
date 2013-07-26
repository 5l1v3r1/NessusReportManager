#!/bin/bash
#
# Mehmet Dursun INCE
# Detecting and Parsing "uptime" command for getting Load Average information
#
echo $(uptime|awk '{print $10" "$11" "$12}')