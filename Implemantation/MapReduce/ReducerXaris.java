package com.mongodb.hadoop.my.project;

import com.mongodb.hadoop.io.BSONWritable;
import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.apache.hadoop.io.DoubleWritable;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapred.JobConf;
import org.apache.hadoop.mapred.OutputCollector;
import org.apache.hadoop.mapred.Reporter;
import org.apache.hadoop.mapreduce.Reducer;
import org.bson.BasicBSONObject;

import java.io.IOException;
import java.util.Iterator;

public class ReducerXaris extends Reducer<Text, DoubleWritable, Text, BSONWritable>
        implements org.apache.hadoop.mapred.Reducer<Text, DoubleWritable, Text, BSONWritable> {

    private static final Log LOG = LogFactory.getLog(ReducerXaris.class);
    private BSONWritable reduceResult;
    //private final Text category;
    public int countAll;

    public ReducerXaris() {
        super();
        reduceResult = new BSONWritable();
        countAll = 0;

    }

    @Override
    public void reduce(final Text pKey, final Iterable<DoubleWritable> pValues, final Context pContext)
            throws IOException, InterruptedException {

        int count = 0;
        double Nsum = 0;
        double Psum = 0;
        double Osum = 0;
        //category.set((pKey).toString());
        //category.set(pKey.toString());
        Text pos = new Text("Positive");
        Text neg = new Text("Negative");
        
        //COUNT THE SUM OF NEGATIVE/POSITIVE/NEUTRAL REVIEWS
        for (DoubleWritable val : pValues) {
            if (pos.equals(pKey)) {
                Psum += 1;
                count++;
                countAll++;

            } else if (neg.equals(pKey)) {
                Nsum += 1;
                count++;
                countAll++;

            } else {
                Osum += 1;
                count++;
                countAll++;

            }
        }

        BasicBSONObject output = new BasicBSONObject();
        output.put("count", count);

        //WRITE TO THE MONGO DATABASE THE SUM FOR EACH KEY
        reduceResult.setDoc(output);
        pContext.write(pKey, reduceResult);
    }

    @Override
    public void reduce(final Text key, final Iterator<DoubleWritable> values,
            final OutputCollector<Text, BSONWritable> output,
            final Reporter reporter) throws IOException {
        int count = 0;
        double Psum = 0;
        double Nsum = 0;

        while (values.hasNext()) {
            if (key.equals("positive")) {
                Psum += 1;
                count++;
            } else {
                Nsum += 1;
                count++;
            }
        }

        final double avg = Psum / count;

        if (LOG.isDebugEnabled()) {
            LOG.debug("Average for key " + key + " was " + avg);
        }

        BasicBSONObject bsonObject = new BasicBSONObject();
        bsonObject.put("count", count);
        bsonObject.put("average of Positives", avg);
        bsonObject.put("Positive sum", Psum);
        bsonObject.put("Negative sum", Nsum);
        reduceResult.setDoc(bsonObject);
        output.collect(key, reduceResult);
    }

    @Override
    public void close() throws IOException {
    }

    @Override
    public void configure(final JobConf job) {
    }
}
