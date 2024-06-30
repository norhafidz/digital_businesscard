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

    // assign $user_id variable to session user id.
    $username = $_SESSION['username'];

    // assign all sessions
    $email = $_SESSION['email'];
    $location = $_SESSION['location'];
    $company = $_SESSION['company'];
    $designation = $_SESSION['designation'];
    $industry = $_SESSION['industry'];
    $date_time = date('Y-m-d H:i:s');
    $fullname = $_SESSION['fullname'];

    // Get tmp and ys
    $ynx = $_GET['yn'];
    $tmp = $_GET['tmp'];

    // check if both tmp and ys are empty

    if (($ynx == '') or (!isset($ynx)) or ($tmp == '') or (!isset($tmp))) {
      // redirect to notfound.php
        header('location:notfound.php');
    } else {

        // decrypt $ynx
        $yn = encrypt_decrypt('decrypt', $ynx);

        // check whether $yn and $tmp is on the database or not.
        $query_CheckDB = mysqli_query($connection, "SELECT * from first where temp='$tmp' and user_id='$yn'");
        $count_CheckDB = mysqli_num_rows($query_CheckDB);

        if ($count_CheckDB <= 0) {
            header('location:notfound.php');
        } else {

        // the rest of the code below

Print ' 
    <br/><br/>
   <div class="container-fluid">
<br/>
    <div data-aos="fade-left"
     data-aos-offset="300"
     data-aos-easing="ease-in-sine">

    <div class="col-xl-5 col-lg-5 col-md-8 col-sm-12 mx-auto">
        <div class="card">
            <div class="card-body" style="padding: 40px;">
            <form method="POST" action="dob.php?tmp='. $tmp .'&yn='. $ynx .'">
                <span style="font-size: 30px;">My phone number is</span><br/><br/>
                <input type="text" class="form-control" name="phone" id="phone" placeholder="0187625353" required /><br/>
                <small class="text-muted">This is the main phone number for your digital business card. We will not share your phone number and it will be stored as encrypted data.</small><br/><br/>
                <div class="d-grid gap-2">
  <button class="btn btn-dark rounded-pill" type="submit"><strong>CONTINUE</strong></button>
</div></form>
            </div>
        </div>
    </div> <!-- end of main div -->

    </div> <!-- end of AOS -->';
    
        include('footer.php');
        } // end of second else
    } // end of first else