#!/bin/bash

name=$1

#delete mongo collection
mongo results --eval "db.$name.drop()"

cd /usr/local/hadoop

# MapReduce job on Mongo collection
bin/hadoop jar /usr/local/hadoop/share/hadoop/mapreduce/Mov.jar \
   com.mongodb.hadoop.my.project.XMLConfigXaris  \
  -Dmongo.input.split_size=8     -Dmongo.job.verbose=true  \
  -Dmongo.input.uri=mongodb://localhost:27017/uploads.$name  \
  -Dmongo.output.uri=mongodb://localhost:27017/results.$name
