#! /bin/bash
###############################
#How to run this script:
#You may want to add it in Cron
#Simple command that keeps log of the date:
#  sh server_monitoring.sh >> $(date +"%Y%m%d")_server.log
###############################
echo "===Beginning==="
#ping -c 1 google.com && echo "Internet connection: OK" || echo "Internet connection: Down"
#publicip=$(curl -s ipecho.net/plain;)
#echo "Public IP : "$publicip

#moodle_dns=$(cat /etc/resolv.conf | grep -v '\#' | awk '{print $2}')
#echo "Name Servers :"$moodle_dns

#free -h | grep -v + > /tmp/ram_cache
#echo "Ram usage:" 
#cat /tmp/ram_cache | grep -v "Swap"
#echo "Swap usage:"
#cat /tmp/ram_cache | grep -v "Mem"

#May slow down the server
#df -h| grep 'Filesystem\|/dev/sda*' > /tmp/disk_usage
#echo "Disk usage:"
#cat /tmp/disk_usage

load_average=$(top -n 1 -b | grep "load average:" | awk '{print $10 $11 $12}')
echo "Load average:"$load_average

conn=$(netstat -an -Ainet,inet6 | grep ESTABLISHED | wc -l)
echo "Number of connections:"$conn

vmst=$(vmstat 1 2 | tail -1 | awk '{print "swap("$3")","free("$4")"}')
echo "Vmstat output:"$vmst

apache_instances=$(ps aux | grep -c apache2)
echo "Apache instances:"$apache_instances

unset load_average vmst conn apache_instances
#rm /tmp/ram_cache
echo "===End===\n\n"
