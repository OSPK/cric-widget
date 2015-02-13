#!/bin/sh
while [ 1 ]; do
    curl -silent GET 'http://104.236.238.110/robot.php?write=go'
    sleep 15
done