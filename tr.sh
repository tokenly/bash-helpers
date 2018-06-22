#!/bin/bash

# Clears the laravel.log or trace.log file, clears the screen and tails the log

# Usage tr.sh [filename]

if [ -z "$1" ]
then
    if [ -e "laravel.log" ]; then
        Filename=laravel.log
    elif [ -e "trace.log" ]; then
        Filename=trace.log
    else
        echo "No suitable logfile found."
        exit 1
    fi
else
    Filename=$1
fi

echo '' > "$Filename";
clear;
echo $Filename
echo "-----------------------------------"
tail -f $Filename
