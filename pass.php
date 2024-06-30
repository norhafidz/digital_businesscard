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

    // assign all sessions
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

    // check if both tmp and ys are empty

    if (($ynx == '') or (!isset($ynx)) or ($tmp == '') or (!isset($tmp)) or ($phx == '') or (!isset($phx))) {
      // redirect to notfound.php
        header('location:notfound.php');
    } else { // first else

        // decrypt $ynx
        $yn = encrypt_decrypt('decrypt', $ynx);
        $ph = encrypt_decrypt('decrypt', $phx);

        // check whether $yn and $tmp is on the database or not.
        $query_CheckDB = mysqli_query($connection, "SELECT * from first where temp='$tmp' and user_id='$yn'");
        $count_CheckDB = mysqli_num_rows($query_CheckDB);

        if ($count_CheckDB <= 0) {
            header('location:notfound.php');
        } else { // second else
            // assign $birthday to submitted value
            $birthday = mysqli_real_escape_string($connection, $_POST['birthday']);

            // check if $birthday is empty
            if (($birthday == '') or (!isset($birthday))) {
                header('location:notfound.php');
            } else { // third else

            // encrypt $phone
            $birthdayx = encrypt_decrypt('encrypt', $birthday);

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
            <form method="POST" action="finalsetup.php?tmp='. $tmp .'&yn='. $ynx .'&ph='. $phx .'&bod='. $birthdayx .'">
                <span style="font-size: 26px;">My password and memorable information are:</span><br/><br/>
                <input type="password" class="form-control" name="password" id="password" placeholder="password" required /><br/>
                <input type="password" class="form-control" name="password2" id="password2" placeholder="retype password" required /><br/>
                <input type="password" class="form-control" name="memorable" id="memorable" placeholder="memorable information" required /><br/>
                <input type="password" class="form-control" name="memorable2" id="memorable2" placeholder="retype memorable information" required /><br/>
                <small class="text-muted">We suggest use the combination of alphanumeric and special characters. <a href="#" data-bs-target="#MemorableWhyModal" data-bs-toggle="modal">What is memorable information?</a></small><br/><br/>
                <div class="d-grid gap-2">
  <button class="btn btn-dark rounded-pill" type="button"><strong>COMPLETE SET UP</strong></button>
</div></form>
            </div>
        </div><br/><br/>
    </div> <!-- end of main div -->

    </div> <!-- end of AOS -->';
    
    include('footer.php');
     } // third else 
        } // second else
    } // first else