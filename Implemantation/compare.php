<?php
//Open a Session to take the email of the user
session_start();
$email = $_SESSION["login_user"];
$name  = substr($email, 0, strpos($email, '@'));

//connect to MongoDB and in user's collection
require 'vendor/autoload.php'; // include Composer's autoloader
$client     = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->results->$name;


// get the q parameter from URL
$q   = $_REQUEST["status"];
$pid = trim($_REQUEST["id"]);

// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    if ($q === "true") {
        //take the pid of process hadoop.sh that runs [2nd field is the pid]
        $cmd     = "ps aux | grep hadoop.sh | awk '{ printf " . '"%s,",$2 }' . "'";
        $output1 = shell_exec($cmd);
        $arr     = explode(',', trim($output1));
        
        //if process of HADOOP is done
        if (!in_array($pid, $arr)) {
            
            $qry1    = array(
                "_id" => "Positive"
            );
            $result1 = $collection->findOne($qry1)->count;
            $qry2    = array(
                "_id" => "Neutral"
            );
            $result2 = $collection->findOne($qry2)->count;
            $qry3    = array(
                "_id" => "Negative"
            );
            $result3 = $collection->findOne($qry3)->count;
            
            $info = array(
                'error' => '0',
                'msg1' => $result1,
                'msg2' => $result2,
                'msg3' => $result3
            );
            echo json_encode($info, JSON_UNESCAPED_UNICODE);
            
        } else {
            echo '{"error":"1"}';
        }
        
    }
}

die();


?>