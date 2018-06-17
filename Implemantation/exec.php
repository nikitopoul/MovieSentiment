<?php
header('Content-type: text/plain; charset=utf-8');

//open a session for each user to take his name
session_start();
$email = $_SESSION["login_user"];
//email --> name
$name = substr($email, 0, strpos($email, '@')); 
   
$task = 0;
$task = shell_exec("./hadoop.sh $name > /dev/null 2>23.txt & echo $!"); 
#The greater-thans (>) in commands like these redirect the program’s output somewhere else

echo $task;
?>