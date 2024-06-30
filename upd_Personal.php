<?php 
    // check whether the session is in tact, if no session, to redirect user to login page.
    session_start();
    if(!(isset($_SESSION['logged-in']))){
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

    // assign $user_id variable to session user id.
    $user_idx = $_GET['id'];
    
    // Encrypt user id.
    $user_id = encrypt_decrypt('decrypt', $user_idx);

    // establish connection to users table.
    $query_UserDetails = mysqli_query($connection, "SELECT * from users where id='$user_id'");

    // check if the user exists.
    $count_UserDetails = mysqli_num_rows($query_UserDetails);

    if ($count_UserDetails <= 0) {
    // execute forwarded to index if no user associated with the id.
       header('location:index.php');

    } else {   

        // get all POST details.
        $fullname = mysqli_real_escape_string($connection, $_POST['fullname']);
        $preferred_name = mysqli_real_escape_string($connection, $_POST['nickname']);
        $designation = mysqli_real_escape_string($connection, $_POST['designation']);
        $company = mysqli_real_escape_string($connection, $_POST['company']);
        $phone = mysqli_real_escape_string($connection, $_POST['phone']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);

        // check POST variables not equal to null

        if (($fullname == '') or (!isset($fullname)) or ($preferred_name == '') or (!isset($preferred_name)) or ($designation == '') or (!isset($designation)) or ($company == '') or (!isset($company)) or ($phone == '') or (!isset($phone)) or ($email == '') or (!isset($email))) {

        // execute this if POST variables is null

        header('location:personal.php?id='. $user_idx .'');

        } else {
        // insert into users table details associated with variables. 

        mysqli_query($connection, "UPDATE users SET fullname='$fullname', preferred_name='$preferred_name', designation='$designation', company='$company', phone='$phone', email='$email' where id='$user_id'");
        header('location:personal.php?id='. $user_idx .'');

        }
    }
?>