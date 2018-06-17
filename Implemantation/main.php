<?php    
   if(!isset($_SESSION)){ session_start(); }
        if ((!isset($_SESSION["login_user"])) || (empty($_SESSION["login_user"])))
       {
          $login_user=true;
       }
   echo null
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Nikitopoulos Thesis Platform</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" type="text/css" href="style2.css"><!--My css -->
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"><!--Css of w3schools -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="http://cdn.phpoll.com/css/animate.css" rel="stylesheet">
      <style>
         body {      line-height: 1.8;
         }
      </style>
   </head>
   <body  id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60" ng-controller="appCtrl" ng-app="myList">
      <div class="">
         <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
               <div class="item active">
                  <img src="/img/data6.jpg">
                  <div class="carousel-caption">
                     <div class="transboxml">
                        <h2 style="text-shadow: 2px 2px #000;"><b>A Hadoop Project</b></h2>
                        <p></p>
                     </div>
                  </div>
               </div>
               <!-- End Item -->
               <div class="item">
                  <img src="img/data2.jpg">
                  <div class="carousel-caption xaris">
                     <div class="transbox">
                        <h3>Upload your Big Data Set</h3>
                        <p>Sentiment Analysis in Film Reviews on Cloud Computing Environment Using MongoDB</p>
                     </div>
                  </div>
               </div>
               <!-- End Item -->
               <div class="item">
                  <img src="img/data7.png">
                  <div class="carousel-caption">
                     <div class="transbox">
                        <h3>Analyze your Data Set</h3>
                        <p>Sentiment Analysis in Film Reviews on Cloud Computing Environment Using MongoDB</p>
                     </div>
                  </div>
               </div>
               <!-- End Item -->
               <div class="item xaris">
                  <img src="img/data4.png">
                  <div class="carousel-caption xaris">
                     <div class="transbox">
                        <h3>See the Sentiment Analysis of your Data Set</h3>
                        <p>Sentiment Analysis in Film Reviews on Cloud Computing Environment Using MongoDB</p>
                     </div>
                  </div>
               </div>
               <!-- End Item -->
            </div>
            <!-- End Carousel Inner -->
            <ul class="nav nav-pills nav-justified">
               <li data-target="#myCarousel" data-slide-to="0" class="active"><a href="#">About<small>Charalampos Nikitopoulos Diploma Thesis</small></a></li>
               <li data-target="#myCarousel" data-slide-to="1"><a href="#">Project<small>Upload your Big Data Set</small></a></li>
               <li data-target="#myCarousel" data-slide-to="2"><a href="#">Hadoop<small>Analyze your Big Data Set</small></a></li>
               <li data-target="#myCarousel" data-slide-to="3"><a href="#">Output<small>See the Sentiment Analysis of your Data Set</small></a></li>
            </ul>
         </div>
         <!-- End Carousel -->
         <nav class="navbar header navbar-fixed-top">
            <div class="container">
               <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>                        
                  </button>
                  <a class="navbar-brand" href="#" >
                  <img src="img/ceid.png" alt="" width="25" height="25">
                  </a>
                  <a class="navbar-brand" href="" >
                  <?php
                     if ((isset($_SESSION["login_user"])) && (!empty($_SESSION["login_user"])))
                       { echo 'Welcome ';
                         $email = $_SESSION["login_user"];
                         $name = substr($email, 0, strpos($email, '@')); 
                         echo $name;} ?>
                  </a>
               </div>
               <div class="collapse navbar-collapse" id="myNavbar">
                  <ul class="nav navbar-nav navbar-right">
                     <li id="enable" ng-if="!login_user" user-data='!login_user'>
                        <a href="/registration.php" class="hvr-sweep-to-top"><span class="glyphicon glyphicon-user"></span> Sign Up</a>
                     </li>
                     <li id="enable" ng-if="!login_user" user-data='!login_user'>  <a href="/login.php" class="hvr-sweep-to-top"><span class="glyphicon"></span> Log In</a>
                     </li>
                     <li>  <a href="/logout.php" class="hvr-sweep-to-top" ng-if="login_user" user-data='login_user'><span class="glyphicon glyphicon-user"></span>Log Out</a></li>
                  </ul>
               </div>
            </div>
         </nav>
      </div>
      <!-- end of nothing div -->
      <div class="back">
         <!-- Upload the Dataset into Mongo -->  
         <div class="container-fluid">
            <div class="panel panel-default">
               <div class="panel-heading"><strong>Upload Files</strong></div>
               <div class="panel-body">
                  <!-- UPLOADING FORM-->
                  <h4>Select a file from your computer</h4>
                  <form id="up" action="upload.php" method="post" enctype="multipart/form-data">
                     <div class="form-inline w3-row">
                        <div class="form-group w3-third">
                           <input type="file" name="filename" id="filename">
                        </div>
                        <div class="w3-third">
                           <button type="submit" class="btn btn-sm btn-primary" name="upload" id="upload" ng-click="login()">Upload file</button>
                        </div>
                        <div class="w3-third" style="display: none" id="stat2">
                           <span id="status" name="status"></span>
                        </div>
                     </div>
                  </form>
                  <!-- EXECUTION OF HADOOP CLUSTER -->
                  <form id="x" class="w3-row ">
                     <button type="submit" name="x1" id="x1" class="w3-btn w3-black w3-hover-yellow" title="Analyze">Execute</button>
                  </form>
               </div>
            </div>
         </div>
         <!-- /container -->
         <div class="w3-container item2" id="apple">
            <!-- The refreshing apple -->
            <span id="r1" style="font-size: 35px;"></span>
         </div>
         <div class="container w3-row">
            <div id="chartContainer" class="w3-half w3-container">  
            </div>
            <div id="chartContainer2" class="w3-half w3-container">  
            </div>
         </div>
         <br><br><br><br><br><br><br><br><br><br><br><br>
      </div>
      <!-- FOOTER -->
      <div class="footer">
         <a href="#myPage" title="To Top">
         <span class="glyphicon glyphicon-chevron-up"></span>
         </a>
         <div class="container2">
            <footer>Copyright 2017 &copy; C Nikitopoulos<br>University of Patras</footer>
         </div>
      </div>
      <!-- SCRIPTS -->
      <script type="text/javascript">
         (function() {
          
             var bar = $('.bar');
             var percent = $('.percent');
             var status = $('#status');
          
             $('#up').ajaxForm({
                 beforeSend: function() {
                     status.empty();
                     var percentVal = '0%';
                     bar.width(percentVal)
                     percent.html(percentVal);
                 },
                 uploadProgress: function(event, position, total, percentComplete) {
                     var percentVal = percentComplete + '%';
                     bar.width(percentVal)
                     percent.html(percentVal);
                 },
                 success: function() {
                     var percentVal = '100%';
                     bar.width(percentVal)
                     percent.html(percentVal);
                 },
                 complete: function(xhr) {
                     status.html(xhr.responseText);
                 }
             });
         })();
         
         
           $(document).ready( function() {
             $('#myCarousel').carousel({
               interval:   5000
           });
           
           var clickEvent = false;
           $('#myCarousel').on('click', '.nav a', function() {
               clickEvent = true;
               $('.nav li').removeClass('active');
               $(this).parent().addClass('active');    
           }).on('slid.bs.carousel', function(e) {
             if(!clickEvent) {
               var count = $('.nav').children().length -1;
               var current = $('.nav li.active');
               current.removeClass('active').next().addClass('active');
               var id = parseInt(current.data('slide-to'));
               if(count == id) {
                 $('.nav li').first().addClass('active');  
               }
             }
             clickEvent = false;
           });
         
         
         $( "#upload" ).click(function() {
           setTimeout(function(){
         console.log('upload phase...');
           $( "#stat2" ).show( "slow" );}, 1000);
         });
         
         //scrool to the result of analysis of execute
         $("#x1").click(function() {
             $('html, body').animate({
                 scrollTop: $("#apple").offset().top
             }, 900);
         });
         
           // Add smooth scrolling to all links in navbar + footer link
           $("a[href='#myPage']").on('click', function(event) {
             // Make sure this.hash has a value before overriding default behavior
             if (this.hash !== "") {
               // Prevent default anchor click behavior
               event.preventDefault();
         
               // Store hash
               var hash = this.hash;
         
               // Using jQuery's animate() method to add smooth page scroll
               // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
               $('html, body').animate({
                 scrollTop: $(hash).offset().top
               }, 900, function(){
            
                 // Add hash (#) to URL when done scrolling (default click behavior)
                 window.location.hash = hash;
               });
             } // End if
           });
           
           $(window).scroll(function() {
             $(".slideanim").each(function(){
               var pos = $(this).offset().top;
         
               var winTop = $(window).scrollTop();
                 if (pos < winTop + 600) {
                   $(this).addClass("slide");
                 }
             });
           });
         });
      </script>
      <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="http://malsup.github.com/jquery.form.js"></script><!--Uploading without reload the page-->
      <script type="text/javascript" src="/assets/script/canvasjs.min.js"></script></head>
      <script src="controller.js" type="text/javascript"></script>
      <script src="ctrl.js"></script>
   </body>
</html>