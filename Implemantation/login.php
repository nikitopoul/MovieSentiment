<!DOCTYPE html>
<html>
   <head>
      <title>Login</title>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
      <link rel="stylesheet" type="text/css" href="style.css">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
   </head>
   <style type="text/css">
      body {
      background-image: url("/img/login1.jpg");
      background-attachment: fixed;
      }
      .login { 
      position: absolute;
      top: 50%;
      left: 50%;
      margin: -150px 0 0 -150px;
      width:350px;
      height:600px;
      }
   </style>
   <body>
      <?php
         require 'vendor/autoload.php'; // include Composer's autoloader
         $client = new MongoDB\Client("mongodb://localhost:27017");
         
          
          
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
           
         // Define variables and initialize with empty values
         $emailErr = $passErr = ""; //messages Errors 
         $email = $pass = $hashed_password = ""; //fields of the users content 
           
         // Processing form data when form is submitted
         if($_SERVER["REQUEST_METHOD"] == "POST")
         { // when log in is clicked 
            
               // Validate email address
             if(empty($_POST["email"]))
             { //if the box is empty
               $emailErr = '<br>Please enter your email address.';     
             }
             else
             {
               $email = filterEmail($_POST["email"]); //if its not empty
             
             if($email == FALSE)
             { //filterEmail return FALSE
               $emailErr = '<br>Please enter a valid email address.';
             }
           }
                
               // Validate password
           if(empty($_POST["pass"]))
           {
             $passErr = '<br>Please enter your password.';     
           }
           else
           {
             $pass = filterString($_POST["pass"]);
                   
             if($pass == FALSE)
             {
               $passErr = '<br><p class="error"> Please enter a valid password.';
             }
           }
               
               // Check input errors before putting them into the base
           if(empty($emailErr) && empty($passErr))
           {   //if in messagesErr is empty then there is no error at all
               //Here we compare if passwords are the same
               
               //connect to db
               $collection = $client->mongo->users;
               
               echo $hashed_password;
               $result = $collection->find( [ 'email' => $email] );
               foreach ($result as $entry) {
                   if(password_verify($pass, $entry['pass']))
                   {  
         
         
                     $hashed_password = $entry['pass'];   
                      }
               }
         
               if($hashed_password){
                         if(!isset($_SESSION)){ session_start(); }
                         $_SESSION["login_user"] = $email;       
                        header("Location:/main.php"); 
                        //back to main page
               }else{echo '<br><br> <p class="error1"> The password or the email are incorrect.</p>';}
             
             }//empty
           }//server_post
         ?>
      <div class="login">
         <form name="loginform" class="input" action="login.php" method="post">
            <fieldset style="border-color: #008CBA; text-align: center" >
               <legend style="font-size: 120%; text-align: center">Login form:</legend>
               <div>E-mail</div>
               <input class="form-control" type="text" id="email" name="email" value="<?php echo $email; ?>">
               <span class="error"> <?php echo $emailErr; ?> </span>
               <div>Password:</div>
               <input type="password" id="pass" name="pass" value="<?php echo $pass; ?>">
               <span class="error"> <?php echo $passErr; ?> </span>
               <br>
               <br>
               <input type="submit" class="button green" value="Log In">
               <p align="center"> <a href="registration.php" style='color:#258e8e'> or register here  </a> </p>
            </fieldset>
         </form>
      </div>
   </body>
</html>