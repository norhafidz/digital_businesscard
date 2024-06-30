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
        $memorable = mysqli_real_escape_string($connection, $_POST['memorable']);
        $newmemorable = mysqli_real_escape_string($connection, $_POST['newmemorable']);
        $newmemorableconfirm = mysqli_real_escape_string($connection, $_POST['newmemorableconfirm']);
        $current = mysqli_real_escape_string($connection, $_POST['current']);

        // check POST variables not equal to null

        if (($memorable == '') or (!isset($memorable)) or ($newmemorable == '') or (!isset($newmemorable)) or ($newmemorableconfirm == '') or (!isset($newmemorableconfirm)) or ($current  == '') or (!isset($current))) {

        // execute this if POST variables is null

        header('location:changememorable.php');

        } else {

        // get details from the users table

        $get_Changepass = mysqli_fetch_array($query_UserDetails);

        // comparing current pass info

         $current_fromDB = $get_Changepass['password'];
        
        if ($current != $current_fromDB) {
        
            //to include error message later - memorable error
             header('location:changememorable.php');
        } else {

            $memorable_fromDB = $get_Changepass['memorable'];

                // comparing current memorable
           if ($memorable != $memorable_fromDB) {
                //to include error message later - current pass error
                header('location:changememorable.php');
            } else {

                // comparing newpass and re-type

                    if ($newmemorable != $newmemorableconfirm) {
                        //to include error message later - newpass and re-type pass error
                         header('location:changememorable.php');
                    } else {

                // update details associated with variables. 

                mysqli_query($connection, "UPDATE users SET memorable='$newmemorable' where id='$user_id'");
                header('location:a_settings.php');

                         }
                }

            } 

        }
    }
?>