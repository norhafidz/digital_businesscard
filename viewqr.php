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

    // set $time to current date&time

    $time = date('Y-m-d H:i');
    
    // Encrypt user id and time.
    $user_idx = encrypt_decrypt('encrypt', $user_id);
    $timex = encrypt_decrypt('encrypt', $time);

    // establish connection to users table.
    $query_UserDetails = mysqli_query($connection, "SELECT * from users where id='$user_id'");

    // check if the user exists.
    $count_UserDetails = mysqli_num_rows($query_UserDetails);

    if ($count_UserDetails <= 0) {
    // Define all params. to 'undefined' if the user is non-exist.
        $fullname = 'Undefined';
        $designation = 'Undefined';
        $company = 'Undefined';
        $header = 'Undefined';

    } else {   

    // get details from table
        $get_UserDetails = mysqli_fetch_array($query_UserDetails);

        // define all params. here if user exist.
        $fullname = $get_UserDetails['fullname'];
        $designation = $get_UserDetails['designation'];
        $company = $get_UserDetails['company'];
        $header = $get_UserDetails['header'];
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
                
                <span class="position-absolute" style="margin-left: 24%; padding-bottom: 20px; margin-top: 45px;"><img class="img-thumbnail" src="https://api.qrserver.com/v1/create-qr-code/?data=http://task0525.epizy.com/card/qrfilter.php?id=<?php echo $user_idx; ?>%26tx=<?php echo $timex; ?>&amp;size=165x165" alt="" title="" /></span>

    <div class="card-body" style="padding: 20px;">
    <center>
    <div style="padding-top:18px;"><br/><br/><br/>
    <span class="mont" style="font-size: 14px;"><?php echo $fullname; ?></span><br/>
    <?php echo $implodex; ?>
    </div>
    <div style="padding-top:5px;">
    <span class="" style="font-size: 12px;"><?php echo $designation; ?> <br/><?php echo $company; ?>
    </div></center>
    </center>
    </div></div><!-- end of card-->
    <br/>
      <div class="list-group">
            <a href="index.php" class="list-group-item list-group-item-action" aria-current="true">
                <span class="" style="font-size: 15px;"><center><strong>Home</strong></center></span>
            </a>
            
            <a href="viewqr.php" class="list-group-item list-group-item-action active"><span class="" style="font-size: 15px;"><center><strong>View QR code</strong></center></span></a>
             <a href="profile.php?id=<?php echo $user_idx; ?>" class="list-group-item list-group-item-action"><span class="" style="font-size: 15px;"><center><strong>View your profile</strong></center></span></a>
            <a href="contact.php" class="list-group-item list-group-item-action"><span class="" style="font-size: 15px;"><center><strong>Contact list</strong></center></span></a>
            <a href="settings.php" class="list-group-item list-group-item-action"><span class="" style="font-size: 15px;"><center><strong>Settings</strong></center></span></a>
            <a href="logout.php" class="list-group-item list-group-item-action"><span class="" style="font-size: 15px;"><center><strong>Logout</strong></center></span></a>
        </div>
        </div><br/>
   </div> <!-- end of core div class -->
<?php include('footer.php'); ?>