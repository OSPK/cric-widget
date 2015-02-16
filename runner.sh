#!/bin/sh
while [ 1 ]; do
    curl 'http://104.236.238.110/robot.php?write=go'
    sleep 10
done