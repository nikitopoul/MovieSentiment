# MovieSentiment
Distributed System for Sentiment Analysis based on Big Datasets of Movies Reviews

This is a personal project and it is uploaded in order to help those who are trying to build a system that uses the same technologies.
For any further information about the implementation you can contact me with e-mail. 

Purpose:
The main purpose of the project was to analyze the emotions of thousands of reviews on a film, in a fast way, to give 
the user an evaluation of how good or bad it was.



Keywords:
Apache Hadoop, Cloud, MongoDB, PHP, Apache HTTP Server, JSON, Big Datasets, Sentiment Analysis, Javascript, AJAX, jQuery, CSS


Technologies (with their versions) that were used:
MongoDB			 3.0
Hadoop			 2.7.3
Apache HTTP Server	 2.44
Ubuntu			 14.04.5
PHP			 5.6.30
Java			 1.8
PHP-MongoDB connector	 1.2.9
Libbson			 1.5.5
Libmongoc		 1.5.5
Hadoop-MongoDB connector 1.5.1



This is an implementation of a distributed system in cloud computing environment to support an online 
application that will handle and analyze Big Data. The work emphasizes the creation and flexible synchronization
of technologies between them in order to quickly serve multiple requests for sentiment analysis for big data sets.
It uses a NoSQL database, MongoDB and a distributed software called Apache Hadoop, which uses the MapReduce 
programming model for parallel works. Data sets for analysis contain raw text, with user reviews about movies in JSON
format that are found from the website imdb.com. 

Firstly, the database and Hadoop were set up in a cluster for testing the synchronization and their communication. 
Then, the web application was implemented through an Apache HTTP Server and an attempt was made to connect all of them. 
The desired result was a user-friendly web application, in a cloud computing environment, that could be expanded to a 
larger scale, adding more capabilities to support a detailed retrospection of movies by user feedback.





/datasets
Here are the dataset inputs that were used for further sentiment analysis originally came from imdb.com website.


/implementation
There are the files that consist of the User Interface of the system and also, the Java files that control the Hadoop clusters 
and calculate the results. There are as well, bash scripts that are needed for the communication of Client, the Server and the Database.

For the connection of PHP and MongoDB, it was used the PHP-MongoDB connector 1.2.9, the libraries libmongoc, libbson and PHPLIB along with
the following code in the files (http://php.net/manual/en/mongodb.tutorial.library.php):

	//connect to database MongoDB
	require 'vendor/autoload.php'; // include Composer's autoloader
	$client = new MongoDB\Client("mongodb://localhost:27017");

For the connection of Apache Hadoop and MongoDB was used the MongoDB Connector for Hadoop, that enables MongoDB to be the input or
output source of the Hadoop MapReduce jobs. (https://docs.mongodb.com/ecosystem/tools/hadoop/)



The sentiment analysis was done through a machine learning technique and it is implemented with Java, using the framework Apache Hadoop
to distribute the code in many clusters to achieve high speed, performance and availability. The User Interface uses HTML5 and CSS3 libraries from
various sources and Javascript, along with jQuery and AJAX for the dynamic reloading and the demonstration of the results. PHP, along with some 
bash scripts, is used for the communication of the UI and the Hadoop or MongoDB







Copyrights 2017: Computer Engineer & Informatics Department (CEID),
University of Patras, Greece 
Charalampos Nikitopoulos, nikitopoul@ceid.upatras.gr
