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
    $user_id = $_SESSION['user_id'];
    
    // Encrypt user id.
    $user_idx = encrypt_decrypt('encrypt', $user_id);

    // establish connection to users table.
    $query_UserDetails = mysqli_query($connection, "SELECT * from users where id='$user_id'");

    // check if the user exists.
    $count_UserDetails = mysqli_num_rows($query_UserDetails);

    if ($count_UserDetails <= 0) {
    // Define all params. to 'undefined' if the user is non-exist.
        $fullname = 'Undefined';
        $designation = 'Undefined';
        $company = 'Undefined';
        $image = 'Undefined';
        $header = 'Undefined';

    } else {   

    // get details from table
        $get_UserDetails = mysqli_fetch_array($query_UserDetails);

        // define all params. here if user exist.
        $fullname = $get_UserDetails['fullname'];
        $designation = $get_UserDetails['designation'];
        $company = $get_UserDetails['company'];
        $image = $get_UserDetails['image'];
        $header = $get_UserDetails['header'];
    }

/*** Calculate no of contacts. ***/

// establish connection to contacts table.
$query_Contacts = mysqli_query($connection, "SELECT * from contacts where user_id='$user_id'");

// check whether there is contacts associated with user.
$count_Contacts = mysqli_num_rows($query_Contacts); 

// set total count to 0 if no contacts associated with user.
if ($count_Contacts <= 0) {
    $total_Contacts = '0'; 

// else count total contacts. 
} else {
    
$total_Contacts = $count_Contacts;
}


/*** Calculate no of views. ***/


// establish connection to analytics table.
$query_Analytics = mysqli_query($connection, "SELECT * from analytics where user_id='$user_id'");

// check whether there is views associated with user.
$count_Analytics = mysqli_num_rows($query_Analytics); 

// set total count to 0 if no views associated with user.
if ($count_Analytics <= 0) {
    $total_Analytics = '0'; 

// else count total views. 
} else {
    
    $total_Analytics = $count_Analytics;
}


// The rest of the HTML code as per below.
   
?>
<div class="container-fluid">
    <div data-aos="fade-left"
     data-aos-offset="300"
     data-aos-easing="ease-in-sine">
   <div class="col-xl-3 col-lg-3 col-md-5 col-sm-10 mx-auto">
   <br/>
    <!--<center><span class="coustard text-white" style="font-size: 24px;"><i class="bi bi-person-badge"></i> &nbsp;beepty</span></center><br/>-->
<div class="card">
    <img src="./<?php echo $header; ?>" class="img-fluid card-img-top position-relative" alt="...">
                <span class="position-absolute" style="padding-left: 34%; padding-bottom: 20px; margin-top: 45px;"><img src="./<?php echo $image; ?>" class="rounded-circle img-thumbnail" style="width: 105px; height: 105px;" /></span>
    <div class="card-body">
    <center>
    <div style="padding-top:65px;">
    <span class="mont" style="font-size: 14px;"><?php echo $fullname; ?> &nbsp;<i class="bi bi-patch-check-fill text-primary"></i></span>
    </div>
    <div style="padding-top:5px;">
    <span class="" style="font-size: 12px;"><?php echo $designation; ?><br/><?php echo $company; ?><hr/>
    <span class="mont" style="font-size: 14px;"><?php echo $total_Contacts; ?></span> <small>Contacts</small> &nbsp;|&nbsp; <span class="mont" style="font-size: 14px;"><?php echo $total_Analytics; ?></span> <small>Profile views</small>
    </span>
    </div></center>
    </div></div><!-- end of card-->
    <br/>
      <a class="text-white mont" href="index.php" style=""><i class="bi bi-house-door" style="font-size: 22px;"></i></a> <i class="bi bi-chevron-right text-white"></i> <a class="text-white mont" href="settings.php" style="font-size: 13px;">Settings</a> <i class="bi bi-chevron-right text-white"></i> <span class="text-white month" style="font-size: 13px;">Personal settings</span><br/><br/>
       <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                <span class="" style="font-size: 15px;"><center><strong>Personal settings</strong></center></span>
            </a>
            <a href="personal.php" class="list-group-item list-group-item-action"><span class="" style="font-size: 15px;"><center><strong>Edit personal details</strong></center></span></a>
            <a href="updateimage.php" class="list-group-item list-group-item-action"><span class="" style="font-size: 15px;"><center><strong>Update profile & header image</strong></center></span></a>
            <a href="updatesocial.php" class="list-group-item list-group-item-action"><span class="" style="font-size: 15px;"><center><strong>Update social media links</strong></center></span></a>
        </div>
        </div><br/>
   </div> <!-- end of core div class -->
<?php include('footer.php'); ?>