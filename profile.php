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

    $current = date('Y-m-d H:i');
    $currentx = strtotime($current);

    // get user_idx and timex from URL
    $user_idx = $_GET['id'];
    $timex = $_GET['tx'];
    
    // decrypt user id and timex
    $user_id = encrypt_decrypt('decrypt', $user_idx);
    $time = encrypt_decrypt('decrypt', $timex);

    $new_time = strtotime($time) + 10 * 60;
    $new_datetime = date('Y-m-d H:i', $new_time);

    // establish connection to users table.
    $query_UserDetails = mysqli_query($connection, "SELECT * from users where id='$user_id'");

    // check if the user exists.
    $count_UserDetails = mysqli_num_rows($query_UserDetails);

    if ($count_UserDetails <= 0) {
    // Define all params. to 'undefined' if the user is non-exist.
        $fullname = 'Undefined';
        $preferred_name = 'Undefined';
        $designation = 'Undefined';
        $company = 'Undefined';
        $image = 'Undefined';
        $header = 'Undefined';
        $location = 'Undefined';
        $linkedin = 'Undefined';
        $facebook = 'Undefined';
        $instagram = 'Undefined';
        $twitter = 'Undefined';
        $website = 'Undefined';

    } else {   

    // get details from table
        $get_UserDetails = mysqli_fetch_array($query_UserDetails);

        // define all params. here if user exist.
        $fullname = $get_UserDetails['fullname'];
        $preferred_name = $get_UserDetails['preferred_name'];
        $designation = $get_UserDetails['designation'];
        $company = $get_UserDetails['company'];
        $image = $get_UserDetails['image'];
        $header = $get_UserDetails['header'];
        $location = $get_UserDetails['location'];
        $linkedin = $get_UserDetails['linkedin'];
        $facebook = $get_UserDetails['facebook'];
        $instagram = $get_UserDetails['instagram'];
        $twitter = $get_UserDetails['twitter'];
        $website = $get_UserDetails['website'];

    }

// The rest of the HTML code as per below.
    ?>
<div class="container-fluid">
<br/>
<div data-aos="fade-left"
     data-aos-offset="300"
     data-aos-easing="ease-in-sine">
    
    <?php
    session_start();
    // Check whether people access this page through their beepty's account.
    if(!(isset($_SESSION['logged-in']))){
        Print '';
    } else {
        Print '<div class="col-xl-4 col-lg-4 col-md-7 col-sm-10 mx-auto"><i class="bi bi-chevron-left text-white"></i> <a class="text-white mont" href="index.php" style="font-size: 14px;">Home</a>
    </div><br/>';
    }
    ?>
   <div class="col-xl-4 col-lg-4 col-md-7 col-sm-10 mx-auto">
        <div class="card align-middle"> 
            <img src="./<?php echo $header; ?>" class="img-fluid card-img-top position-relative" alt="...">
                <span class="position-absolute bottom-50 top-20 start-20" style="padding-left: 34%; padding-bottom: 20px;"><img src="./<?php echo $image; ?>" class="rounded-circle img-thumbnail" style="width: 125px; height: 125px;" /></span>
                
        <div class="card-body" style="padding-left: 10px;">
        <br/><br/><center>
            <div style="padding-top: 15px;">
                <span class="mont" style="font-size: 16px;"><?php echo $fullname; ?></span> &nbsp;<i class="bi bi-patch-check-fill text-primary"></i>
            </div>
            <div style="padding-top: 0px;">
                <span class="text-dark" style="font-size: 15px;"><?php echo $designation; ?><br/><?php $company; ?></span>
            </div>
             <div style="padding-top: 0px;">
                <span class="text-muted" style="font-size: 13px;"><?php echo $location; ?></span>
            </div>
                <div style="padding-top: 15px; padding-bottom:15px;">
                <a href="<?php echo $linkedin; ?>" target="_blank" class="text-secondary"><i class="bi bi-linkedin" style="font-size: 18px;"></i></a> &nbsp;&nbsp; <a href="<?php echo $facebook; ?>" target="_blank" class="text-secondary"><i class="bi bi-facebook" style="font-size: 18px;"></i></a> &nbsp;&nbsp; <a href="<?php echo $instagram; ?>" target="_blank" class="text-secondary"><i class="bi bi-instagram" style="font-size: 18px;"></i></a> &nbsp;&nbsp; <a href="<?php echo $twitter; ?>" target="_blank" class="text-secondary"><i class="bi bi-twitter" style="font-size: 18px;"></i></a> &nbsp;&nbsp; <a href="https://wa.me/60197496825" target="_blank" class="text-secondary"><i class="bi bi-whatsapp" style="font-size: 18px;"></i></a>
            </div></center><br/>
            <div class="col-xl-10 col-lg-10 col-md-8 col-sm-7 mx-auto">
                <div class="row">
                    <div class="col">
                        <div class="d-grid gap-2">
                            <?php 
                            if (($current >= $time) and ($current <= $new_datetime)) {
                                Print  '<a class="btn btn-primary rounded-pill" href="save.php?id='. $user_idx .'"><strong>Save</strong></a>
                                ';
                            } else {
                               Print '<a class="btn btn-primary rounded-pill disabled" href="#"><strong>Save</strong></a>';
                            }
                            ?>

                        </div>
                    </div>
                    <div class="col">
                    <div class="d-grid gap-2">
                    <?php 
                            if (($current >= $time) and ($current <= $new_datetime)) {
                                Print  '<a class="btn btn-primary rounded-pill" href="tel:123-456-7890"><strong>Call</strong></a>
                                ';
                            } else {
                               Print '<a class="btn btn-primary rounded-pill disabled" href="#"><strong>Call</strong></a>';
                            }
                            ?>
                    </div>
                    </div>
                    <div class="col">
                        <div class="d-grid gap-2">
                         <?php 
                            if (($current >= $time) and ($current <= $new_datetime)) {
                                Print  '<a class="btn btn-outline-secondary rounded-pill" href="#" data-bs-toggle="modal" data-bs-target="#connectModal"><strong>Connect</strong></a>
                                ';
                            } else {
                               Print '<a class="btn btn-outline-secondary rounded-pill disabled" href="#"><strong>Connect</strong></a>';
                            }
                            ?>
                            
                        </div>
                    </div>
                </div>  
                </div>        
            </div>
        </div> 
        </div><!-- end of card --><br/>
   </div> <!-- end of core div class -->

<?php include('footer.php'); ?>