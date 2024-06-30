<?php

    // check whether the session is in tact, if no session, to redirect user to login page.
    session_start();
    if(!(isset($_SESSION['username']))){
        header('Location: login.php');
        exit();
    }

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

    // assign all sessions.
    $email = $_SESSION['email'];
    $location = $_SESSION['location'];
    $company = $_SESSION['company'];
    $designation = $_SESSION['designation'];
    $industry = $_SESSION['industry'];
    $date_time = date('Y-m-d H:i:s');
    $fullname = $_SESSION['fullname'];

    // Get tmp, ph and ys
    $ynx = $_GET['yn'];
    $tmp = $_GET['tmp'];
    $phx = $_GET['ph'];
    $bodx = $_GET['bod'];

    // check if both tmp and ys are empty

    if (($ynx == '') or (!isset($ynx)) or ($tmp == '') or (!isset($tmp)) or ($phx == '') or (!isset($phx)) or ($bodx == '') or (!isset($bodx))) {
      // redirect to notfound.php
        header('location:notfound.php');
    } else { // first else

        // decrypt $ynx
        $yn = encrypt_decrypt('decrypt', $ynx);
        $ph = encrypt_decrypt('decrypt', $phx);
        $bod = encrypt_decrypt('decrypt', $bodx);

        // check whether $yn and $tmp is on the database or not.
        $query_CheckDB = mysqli_query($connection, "SELECT * from first where temp='$tmp' and user_id='$yn'");
        $count_CheckDB = mysqli_num_rows($query_CheckDB);

        if ($count_CheckDB <= 0) {
            header('location:notfound.php');
        } else { // second else

            // get id
            $get_CheckDB = mysqli_fetch_array($query_CheckDB);
            $user_id = $get_CheckDB['id'];
            
            // assign password, memorable
            $password = mysqli_real_escape_string($connection, $_POST['password']);
            $password2 = mysqli_real_escape_string($connection, $_POST['password2']);
            $memorable = mysqli_real_escape_string($connection, $_POST['memorable']);
            $memorable2 = mysqli_real_escape_string($connection, $_POST['memorable2']);

            if ($password != $password2) {
                header('location:pass.php?tmp='. $tmp .'&yn='. $ynx .'&ph='. $phone .'');
            } else { // third else

            if ($memorable != $memorable2) {
                header('location:pass.php?tmp='. $tmp .'&yn='. $ynx .'&ph='. $phone .'');
            } else { // fourth else

            // check if $birthday is empty
            if (($password == '') or (!isset($password)) or ($password2 == '') or (!isset($password2)) or ($memorable == '') or (!isset($memorable)) or ($memorable2 == '') or (!isset($memorable2))) {
                header('location:notfound.php');
            } else { // fifth else

            $birthday = date('Y-m-d H:i:s');

            mysqli_query($connection, "INSERT into users (login, password, memorable, fullname, dob, u_level, email, designation, company, phone, date_time, location, industry) values ('$username', '$password', '$memorable', '$fullname', '$birthday', '2', '$email', '$designation', '$company', '', '', '', '')")



                } // fifth else
            } // fourth else
         } // third else 
    } // second else
} // first else