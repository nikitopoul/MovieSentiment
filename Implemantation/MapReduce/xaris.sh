#!/bin/bash


cd /home/xaris/

#remove an existing folder with the same name, local
rm -f -r build/* 
rm -f -r Mov.jar

#compile
javac -classpath /usr/local/hadoop/share/hadoop/common/hadoop-common-2.7.3.jar:/usr/local/hadoop/share/hadoop/mapreduce/hadoop-mapreduce-client-core-2.7.3.jar:/usr/local/hadoop/share/hadoop/common/lib/commons-cli-1.2.jar:/home/xaris/Downloads/jars/* src/main/java/com/mongodb/hadoop/my/project/MapperXaris.java src/main/java/com/mongodb/hadoop/my/project/ReducerXaris.java src/main/java/com/mongodb/hadoop/my/project/XMLConfigXaris.java -d build -Xlint

#make a jar
jar -cvf Mov.jar -C build/ .

#delete mongo collection
mongo mongo_hadoop --eval "db.result.drop()"

#execute mapreduce job "~/hadoop-binaries/bin/"
hadoop jar /home/Mov.jar \
  com.mongodb.hadoop.my.project.XMLConfigXaris  \
  -Dmongo.input.split_size=8     -Dmongo.job.verbose=true  \
  -Dmongo.input.uri=mongodb://localhost:27017/mongo_hadoop.movies  \
  -Dmongo.output.uri=mongodb://localhost:27017/mongo_hadoop.result 




