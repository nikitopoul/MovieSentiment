package com.mongodb.hadoop.my.project;

import com.mongodb.hadoop.MongoInputFormat;
import com.mongodb.hadoop.MongoOutputFormat;
import com.mongodb.hadoop.io.BSONWritable;
import com.mongodb.hadoop.util.MapredMongoConfigUtil;
import com.mongodb.hadoop.util.MongoConfigUtil;
import com.mongodb.hadoop.util.MongoTool;
import org.apache.hadoop.io.DoubleWritable;

// Basic MapReduce utility classes
import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.conf.Configured;
import org.apache.hadoop.util.Tool;
import org.apache.hadoop.util.ToolRunner;
import org.apache.hadoop.mapreduce.Job; 

// Classes for File IO
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;

// Wrappers for data types
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;

// Configurable counters
import org.apache.hadoop.mapreduce.Counters;
import org.apache.hadoop.mapreduce.Counter;

public class XMLConfigXaris extends MongoTool implements Tool {
    public XMLConfigXaris() throws Exception{
        this(new Configuration(), new String[100]);
    }

    public XMLConfigXaris(final Configuration conf, String[] args) throws Exception{
       
        setConf(conf);

        if (MongoTool.isMapRedV1()) {
            MapredMongoConfigUtil.setInputFormat(conf, com.mongodb.hadoop.mapred.MongoInputFormat.class);
            MapredMongoConfigUtil.setOutputFormat(conf, com.mongodb.hadoop.mapred.MongoOutputFormat.class);
        } else {
            MongoConfigUtil.setInputFormat(conf, MongoInputFormat.class);
            MongoConfigUtil.setOutputFormat(conf, MongoOutputFormat.class);
        }
        MongoConfigUtil.setMapper(conf, MapperXaris.class);
        MongoConfigUtil.setMapperOutputKey(conf, Text.class);
        MongoConfigUtil.setMapperOutputValue(conf, DoubleWritable.class);

        MongoConfigUtil.setReducer(conf, ReducerXaris.class);
        MongoConfigUtil.setOutputKey(conf, Text.class);
        MongoConfigUtil.setOutputValue(conf, BSONWritable.class);

    }

    public static void main(final String[] pArgs) throws Exception {
        System.exit(ToolRunner.run(new XMLConfigXaris(), pArgs));
    }
}