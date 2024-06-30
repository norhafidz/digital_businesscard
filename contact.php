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

    if (($user_idx == '') or (!isset($user_idx))) {

        header('location: index.php');

    } else {

    // decrypt user id.
    $user_id = encrypt_decrypt('decrypt', $user_idx);

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
}

// The rest of the HTML code as per below.
 ?>
<div class="container-fluid">
    <div data-aos="fade-left"
     data-aos-offset="300"
     data-aos-easing="ease-in-sine">
<br/>
        <div class="col-xl-3 col-lg-3 col-md-5 col-sm-10 mx-auto">
                <i class="bi bi-chevron-left text-white"></i> <a class="text-white mont" href="index.php" style="font-size: 14px;">Home</a><br/><br/>
                <span class="mont text-white" style="font-size: 18px;">Contacts</span>
                <br/><br/>
                <input class="form-control" id="myInput" type="text" placeholder="Search..">
                <br/>
                <div class="list-group" id="myTable">
                <?php
                // establish connection to contacts table
                $query_Contacts = mysqli_query($connection, "SELECT * from contacts where user_id='$user_id'");
                
                // check whether contact list exist or not
                $count_Contacts = mysqli_num_rows($query_Contacts);
    
                if ($count_Contacts >= 1) {
                       // execute the loop if there is contact associated with user in the table.
                       while ($row_Contacts = mysqli_fetch_array($query_Contacts)) {
                        
                           // encrypt contact ID.
                           $contact_IDx = encrypt_decrypt('encrypt', $row_Contacts['id']);

                            // loop started, displaying the all the contact details associated with the user.
                           Print '<a href="condetails.php?id='. $user_idx .'&ctc='. $contact_IDx .'" class="list-group-item list-group-item-action">
                                <span class="mont" style="font-size: 13px;"> <img src="./'. $row_Contacts['image'] .'" class="rounded-circle img-thumbnail" style="width: 45px; height: 45px;" /> &nbsp;&nbsp;'. $row_Contacts['fullname'] .'</span>
                           </a>';
                       }

                } else {
                    // execute the code below if no contact associated with user in the table.
                    Print '
                    <a href="#" class="list-group-item list-group-item-action">
                        <span class="mont" style="font-size: 13px;">You have no contact list yet.</span>
                    </a>';
                }

                // The rest of the HTML code as per below.
                ?>
                </div>
                   
                <br/>
        </div> <!-- end of core div class -->
    </div> <!-- end of aos div class -->
<?php include('footer.php'); ?>