#!/bin/sh
while [ 1 ]; do
    curl GET 'http://104.236.238.110/robot.php?write=go'
    sleep 10
done