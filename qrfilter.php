<?php 
    // check whether the session is in tact, if no session, to redirect user to login page.
    /*session_start();
    if(!(isset($_SESSION['logged-in']))){
        header('Location: login.php');
        exit();
    }*/

    // require connect.php
    require_once "connect.php";

    // include header and encrypt.
    include('header.php'); 
    include('encrypt.php');

    // establish connection to DB.
    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    // if connection to DB is unsuccessful, display the connection error. 
    if($connection->connect_errno!=0){
        echo "Error: ".$connection->connect_errno . "<br>";
        echo "Description: " . $connection->connect_error;
        exit();
    }
    // get user_idx and timex from URL
    $user_idx = $_GET['id'];
    $timex = $_GET['tx'];
    
    // check whether GET have content.

    if (($user_idx == '') or (!isset($user_idx)) or ($timex == '') or (!isset($timex))) {
        // redirect to error_while_scanning.php if no content
        header('location:error_while_scanning.php');

    // first else
    } else {

    // decrypt user id and timex
    $user_id = encrypt_decrypt('decrypt', $user_idx);
    $time = encrypt_decrypt('decrypt', $timex);

    // establish connection to users table.
    $query_UserDetails = mysqli_query($connection, "SELECT * from users where id='$user_id'");

    // check if the user exists.
    $count_UserDetails = mysqli_num_rows($query_UserDetails);

    if ($count_UserDetails <= 0) {
    // forwarded to error while scanning
    header('location:error_while_scanning.php');

    // second else
    } else {  

        mysqli_query($connection, "INSERT into analytics (user_id, date_time) values ('$user_id', '$time')");
        header('location: profile.php?id='. $user_idx .'&tx='. $timex .'');

        // end of second else
        } 

    // end of first else
    } 
// end of PHP
?>