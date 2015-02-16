# Cricket Scores Widget
Do:

Change the URL

    curl 'http://104.236.238.110/robot.php?write=go'

in "runner.sh"

to:

    curl 'http://yourdomain/robot.php?write=go'

then run in terminal:

    nohup ./runner.sh &

to start the runner, fetch data from YQL and save to relevant data/.json file
