<!DOCTYPE html>
<html>
   <head>
      <title>Register</title>
      <link rel="shortcut icon" href="favicon.ico" />
      <link rel="stylesheet" type="text/css" href="style.css">
   </head>
   <style>
      body {
      background: url(img/forest.jpg);
      font: 400 15px Lato, sans-serif;
      line-height: 1.8;
      color: #483D8B;
      }
   </style>
   <body>
      <?php
         require 'vendor/autoload.php'; // include Composer's autoloader
         $client = new MongoDB\Client("mongodb://localhost:27017");
          
         //******************************************FUNCTIONS DECLARATION*************************************
         
         // Functions to filter user inputs    
         function filterEmail($field){
             // Sanitize e-mail address
             $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);
              
             // Validate e-mail address
             if(filter_var($field, FILTER_VALIDATE_EMAIL)){
                 return $field;
             }else{
                 return FALSE;
             }
         }
         
         function filterString($field){
             // Sanitize string
             $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
             if(!empty($field)){
                 return $field;
             }else{
                 return FALSE;
             }
         }
         
         
         
         function generateRandomString($length = 10) {
             $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
             $charactersLength = strlen($characters);
             $randomString = " ";
             for ($i = 0; $i < $length; $i++) {
                 $randomString .= $characters[rand(0, $charactersLength - 1)];
             }
             return $randomString;
             echo $randomString;
         }
         
         
           
         // Define variables and initialize with empty values
         $emailErr = $passErr = "";
         $email = $pass1 = $pass2 = "";
         
         
         
         
         // Processing form data when form is submitted
         if($_SERVER["REQUEST_METHOD"] == "POST"){ //when user click on register
           
          
             // Validate email address
             if(empty($_POST["email"])){
                 $emailErr = '<br>Please enter your email address.';    
             }else{
                 $email = filterEmail($_POST["email"]);
                 if($email == FALSE){
                     $emailErr = '<br>Please enter a valid email address.';
                 }
             }
              
             // Validate password(not comparing passwords here)
             if(empty($_POST["pass1"])){
                 $passErr = '<br>Please enter your password.';    
             }else{
                 $pass1 = filterString($_POST["pass1"]);
                 if($pass1 == FALSE){
                     $passErr = '<br><p class="error"> Please enter a valid password.';
                 }
             }
             if(empty($_POST["pass2"])){
                 $passErr = '<br>Please enter your password.';     
             }else{
                 $pass2 = filterString($_POST["pass1"]);
                 if($pass2 == FALSE){
                     $passErr = '<br><p class="error"> Please enter a valid password.';
                 }
             }
              
             // Check input errors before putting them into the base
             if(empty($emailErr) && empty($passErr)){ //if it is all right 
                  
                 if ($_POST["pass1"]==$_POST["pass2"]) { //check passwords to be the same
                 
                     if($client){
                          $hashed_password = password_hash($pass1, PASSWORD_DEFAULT);
         
         
                          $mongo = 'mongo';
                          //connecting to database
                          $db=$client->$mongo;
         
                          //connect to specific collection
                          $users=$db->users;
                          $query=array('email'=>$email);
         
                          //checking for existing user
                          $count=$users->findOne($query);
                          if(!count($count)){
                              //Save the New user
                             $collection = $client->mongo->users;
         
                             $collection->insertOne( [ 'email' => $email, 'pass' => $hashed_password ] );
                             if(!isset($_SESSION)){ session_start(); }
                             $_SESSION["login_user"] = $email; 
                             header("Location:/main.php"); //the main page
                         }else{
                              echo "<br><br> <p class='error1'>Email is already existed. Please register with another Email id!";
                              }
         
         
                     }else{
                           die('<br><br> <p class="error1">The passwords must be the same!');
                          }
         
                 }else{echo '<br><br> <p class="error1">The passwords must be the same!';} 
             }
         }
          
         ?>
      <div class="login">
         <form name="signupform" class="input" action="registration.php" method="post">
            <fieldset style="border-color: #008CBA; text-align: center" >
               <legend style="font-size: 120%; text-align: center">Sign up form:</legend>
               <div>E-mail</div>
               <input type="text" id="email" name="email" value="<?php echo $email; ?>">
               <span class="error"> <?php echo $emailErr; ?> </span>
               <div>Password:</div>
               <input type="password" id="pass1" name="pass1" value="<?php echo $pass1; ?>">
               <span class="error"> <?php echo $passErr; ?> </span>
               <div>Password Verification:</div>
               <input type="password" id="pass2" name="pass2" value="<?php echo $pass2; ?>">
               <span class="error"> <?php echo $passErr; ?> </span>
               <br>
               <br>
               <button class="button blue" value="Send">Register</button>
            </fieldset>
         </form>
      </div>
   </body>
</html>