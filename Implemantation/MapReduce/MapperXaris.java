package com.mongodb.hadoop.my.project;

import com.mongodb.hadoop.io.BSONWritable;
import org.apache.hadoop.io.DoubleWritable;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapred.JobConf;
import org.apache.hadoop.mapred.OutputCollector;
import org.apache.hadoop.mapred.Reporter;
import org.apache.hadoop.mapreduce.Mapper;
import org.bson.BSONObject;
import org.bson.types.ObjectId;

// Basic Java file IO 
import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.net.URI;

// Java classes for working with sets
import java.util.ArrayList;
import java.util.HashSet;
import java.util.Set;

// Regular expression utility
import java.util.regex.Pattern;

// File I/O
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.input.FileSplit;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;

// Mapper parent class and the Configuration class
import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.mapreduce.Mapper;

// Wrappers for values
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.LongWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.util.StringUtils;

// Configurable counters
import org.apache.hadoop.mapreduce.Counters;
import org.apache.hadoop.mapreduce.Counter;

import java.io.IOException;
import java.util.StringTokenizer;

public class MapperXaris extends Mapper<Object, BSONObject, Text, DoubleWritable>
    {

    private final Text keyInt;
    private final Text review;
    private final DoubleWritable valueDouble;

    public MapperXaris() {
        super();
        keyInt = new Text();
        review = new Text();
        valueDouble = new DoubleWritable();
    }

    @Override
    @SuppressWarnings("deprecation")
    public void map(final Object pKey, final BSONObject pValue, final Context pContext) throws IOException, InterruptedException {

        int posCounter = 0;
        int negCounter = 0;
        
        //LISTS WITH SENTIMENT WORDS
        List<String> goodList = new ArrayList<>(Arrays.asList("astounding", "bedazzling", "brilliant", "breathtaking", "classy", "compelling", "dazzling", "eclipsing", "elite", "enriching", "epic", "flawless", "first-rate", "gripping", "groundbreaking", "gut-wrenching", "headline-worthy", "iconic", "impeccable", "insightful", "inspired", "kick-Ass", "laudable", "legendary", "luminous", "masterful", "notable", "pioneering", "pitch-perfect", "pivotal", "prime", "provocative", "refined", "rich", "riveting", "sensational", "stellar", "to die for", "trailblazing", "thought-provoking", "touching", "transcendent", "unforgettable", "vibrant", "world class"));
        List<String> badList = new ArrayList<>(Arrays.asList("atrocious", "awful", "cheap", "crummy", "dreadful", "sad", "unacceptable", "blah", "bummer", "synthetic", "abominable", "amiss", "bad news", "beastly", "cruddy", "defective", "grungy", "icky", "inadequate", "incorrect", "not good", "stinking", "substandard", "the pits", "unsatisfactory"));
        
        //THE REVIEW
        review.set((pValue.get("review")).toString());
        String[] stringArray = review.toString().split("\\s+|,");

        for (String currentString : stringArray) {
            //COMPARING EACH WORD COMING FROM DATABASE WITH THE 'GOOD' LIST
            if (goodList.contains(currentString.toLowerCase())) {
                //System.out.println("WE FIND A GOOD WORD");
                posCounter++;
            }
            //COMPARING EACH WORD COMING FROM DATABASE WITH THE 'BAD' LIST            
            if (badList.contains(currentString.toLowerCase())) {
                //System.out.println("WE FIND A BAD WORD");
                negCounter++;
            }
        }

        //DECIDE THE SENTIMENT LABEL/KEY OF EACH REVIEW 
        if (posCounter > negCounter) {
            keyInt.set("Positive");
        } else if (posCounter < negCounter) {
            keyInt.set("Negative");
        } else {
            keyInt.set("Neutral");
        }

        //SENDING THE VALUE KEY PAIR TO REDUCE PHASE
        valueDouble.set(1);
        pContext.write(keyInt, valueDouble);
    }

}
