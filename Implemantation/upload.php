<?php
   //connect to database MongoDB
   require 'vendor/autoload.php'; // include Composer's autoloader
   $client = new MongoDB\Client("mongodb://localhost:27017");
   
   //open a session for each user
   session_start();
   $email = $_SESSION["login_user"];   
   $name = substr($email, 0, strpos($email, '@')); 

   //for comparing the format of the uploaded file
   $allowed =  'text/plain';
   $type = mime_content_type($_FILES['filename']['tmp_name']);

   #If there is a file && user has logged in -->   make the upload
   if (isset($_POST['upload']) && isset($email)) {
              if(isset($_FILES['filename'])) {
                   if($_FILES['filename']['size'] > 2048576000)       { 
                   //2 GB --> If there are many clusters leaveFile too big
                       printf("<h4 class='w3-container w3-section w3-red w3-round'><strong>File is too big.</strong></h4>");
                   }elseif (!($type==$allowed) ) { //Typical check for the json format/text format
                       printf("<h4 class='w3-container w3-section w3-red w3-round'>Allowed only JSON format.</h4>");
                   }else {

                       #Connect to specific collection
                       $collection = $client->uploads->$name;

                       #DELETE EXISTING RECORD
                       $qry = array("id" => 0);
                       $result = $collection->findOne($qry);
                       if($result){
                           #If there is another file of the same user(email)--> delete the file
                           $deleteResult = $collection->drop();
                           printf("Deleted previous file.");
                       }
   
                       //Uploading the File
                      $zips = file_get_contents($_FILES['filename']['tmp_name']);
                       
                       //Json into Array
                      $arr = array(json_decode($zips, true));

                      foreach ($arr as $value){
                        $size = sizeof($value);
                        //INSERT RECORDS TO MONGO
                        for ($i=0; $i < $size; $i++) { 

                          $insertManyResult = $collection->insertOne(
                            [   'id' => $i,
                            'review' => $value[$i]['review']
                            ]
                          );
                        }
                      }

                       if ($collection) {
                          printf("<h4 class='w3-container w3-section w3-green w3-round'><strong>Upload finished succesfuly!</strong></h4>");
                          printf("Inserted %d document(s)\n", $size );
                       }

                   }
               } 
   }
               
   
   ?>