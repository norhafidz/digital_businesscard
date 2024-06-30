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
   <i class="bi bi-chevron-left text-white"></i> <a class="text-white mont" href="a_settings.php" style="font-size: 12px;">Back</a><br/><br/>
    <span class="mont text-white" style="font-size: 18px;">Change memorable information</span>
   <br/><br/>
        <div class="card">
            <div class="card-body" style="padding: 25px;">
            <form action="memorable_change.php?id=<?php echo $user_idx; ?>" method="POST">
            <div class="mb-3">
                    <label for="memorable" class="form-label" style="font-size: 14px;">Current password:</label>
                        <input type="password" class="form-control" id="current" name="current" placeholder="" required>
                </div>
                <div class="mb-3">
                    <label for="current" class="form-label" style="font-size: 14px;">Current memorable information:</label>
                        <input type="password" class="form-control" id="memorable" name="memorable" placeholder="" required>
                </div>
                <div class="mb-3">
                    <label for="newpass" class="form-label" style="font-size: 14px;">New memorable information:</label>
                        <input type="password" class="form-control" id="newmemorable" name="newmemorable" placeholder="" required>
                </div>
                <div class="mb-3">
                    <label for="newpassconfirm" class="form-label" style="font-size: 14px;">Retype new memorable information:</label>
                        <input type="password" class="form-control" id="newmemorableconfirm" name="newmemorableconfirm" placeholder="" required>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-dark" type="submit"><strong>Update memorable</strong></button>
                </div>
                </form>
            </div> 
            </div>
        </div> <!-- end of card div --><br/>
   </div> <!-- end of core div class -->
<?php include('footer.php'); ?>