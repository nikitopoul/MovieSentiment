<?php
 if(!isset($_SESSION)){ session_start(); }

     if(!empty($_SESSION['login_user'])){
         echo json_encode($_SESSION['login_user']);
     }
     echo null;
?>