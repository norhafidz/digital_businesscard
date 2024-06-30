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
        $prefered_name = 'Undefined';
        $designation = 'Undefined';
        $company = 'Undefined';
        $phone = 'Undefined';
        $email = 'Undefined';
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
        $phone = $get_UserDetails['phone'];
        $email = $get_UserDetails['email'];
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
    <br/><br/>
<div data-aos="fade-left"
     data-aos-offset="300"
     data-aos-easing="ease-in-sine">

   <div class="col-xl-3 col-lg-3 col-md-5 col-sm-10 mx-auto">
   <i class="bi bi-chevron-left text-white"></i> <a class="text-white mont" href="p_settings.php" style="font-size: 13px;">Back</a><br/><br/>
    <span class="mont text-white" style="font-size: 18px;">Update profile picture</span>
   <br/><br/>
        <div class="card">
            <div class="card-body" style="padding: 25px;">
                 <form action="proimageupdate.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <center><img src="./<?php echo $image; ?>" class="img-thumbnail rounded-circle" style="width: 95px; height: 95px;" />
                <br/><br/>
                <input class="form-control" type="file" id="image" name="image" required /> 
                <label for="formFile" class="form-label mont" style="font-size: 11px;">Kindly ensure your file is less than 2MB.</label>
            </div></center>
                
                <div class="d-grid gap-2">
                    <button class="btn btn-dark" type="submit" name="submit" value="Upload"><strong style="font-size: 13px;">Update profile picture</strong></button>
                </div>
                </form>
            </div>
        </div> <!-- end of card div --><br/><br/>
        <span class="mont text-white" style="font-size: 18px;">Update profile cover</span>
   <br/><br/>
        <div class="card">
        <img src="./<?php echo $header; ?>" class="img-fluid card-img-top position-relative" alt="...">
            <div class="card-body" style="padding: 25px;">
                  <form action="proheaderupdate.php?id=<?php echo $user_id; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <center>
                <input class="form-control" type="file" id="image" name="image" required /> 
                <label for="formFile" class="form-label mont" style="font-size: 11px;">Kindly ensure your file is less than 2MB.</label>
            </div></center>
                <div class="d-grid gap-2">
                    <button class="btn btn-dark" type="submit" name="submit" value="Upload"><strong style="font-size: 13px;">Update profile cover</strong></button>
                </div>  </form>
            </div>
        </div> <!-- end of card div --><br/>
   </div> <!-- end of core div class -->
<?php include('footer.php'); ?>