#!/bin/bash


cd /usr/local/hadoop
bin/hadoop namenode -format 
./sbin/start-all.sh
jps




