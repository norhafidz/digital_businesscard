<?php

session_start();
require_once "connect.php";
include('encrypt.php');

$connection = new mysqli($host, $db_user, $db_password, $db_name);

if($connection->connect_errno!=0){
    echo "Error: ".$connection->connect_errno . "<br>";
    echo "Description: " . $connection->connect_error;
}
else {
    $temp = $_GET['tmp'];
    
    $query_CheckFirst = mysqli_query($connection, "SELECT * FROM first WHERE temp='$temp'");
    $count_CheckFirst = mysqli_num_rows($query_CheckFirst); 

    if ($count_CheckFirst <= 0) {
        
      header('location:notfound.php');
      
    } else {

        $get_CheckFirst = mysqli_fetch_array($query_CheckFirst);

        $username = $get_CheckFirst['user_id'];
        $email = $get_CheckFirst['email'];
        $location = $get_CheckFirst['location'];
        $company = $get_CheckFirst['company'];
        $designation = $get_CheckFirst['designation'];

        $usernamex = encrypt_decrypt('encrypt', $username);

         $_SESSION['username'] = $username;
         $_SESSION['email'] = $email;
         $_SESSION['location'] = $location;
         $_SESSION['company'] = $company;
         $_SESSION['designation'] = $designation;

         header('location:name.php?tmp='. $temp .'&yn='. $usernamex .'');
    }
}

?>