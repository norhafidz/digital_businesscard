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
    $ctcx = $_GET['ctc'];

    if (($user_idx == '') or (!isset($user_idx)) or ($ctcx == '') or (!isset($ctcx))) {

        header('location: contact.php?id='. $user_idx .'');

    } else {

    // decrypt user id.
    $user_id = encrypt_decrypt('decrypt', $user_idx);
    $ctc = encrypt_decrypt('decrypt', $ctcx);

    // establish connection to contacts table.
    $query_ContactDetails = mysqli_query($connection, "SELECT * from contacts where id='$ctc' and user_id='$user_id'");

    // check if the user exists.
    $count_ContactDetails = mysqli_num_rows($query_ContactDetails);

    if ($count_ContactDetails <= 0) {
    // Define all params. to 'undefined' if the user is non-exist.
       


    } else {   

    // get details from table
        $get_ContactDetails = mysqli_fetch_array($query_ContactDetails);

        // define all params. here if user exist.
        $fullname = $get_ContactDetails['fullname'];
        $designation = $get_ContactDetails['designation'];
        $company = $get_ContactDetails['company'];
        $image = $get_ContactDetails['image'];
        $remarks = $get_ContactDetails['remarks'];
        $phone = $get_ContactDetails['phone'];
        $email = $get_ContactDetails['email'];

    }
}

// The rest of the HTML code as per below.
 ?>
<div class="container-fluid">
    <br/><br/><br/>
    <div data-aos="fade-left"
     data-aos-offset="300"
     data-aos-easing="ease-in-sine">
     <div class="col-xl-4 col-lg-4 col-md-7 col-sm-10 mx-auto">
      <i class="bi bi-chevron-left text-white"></i> <a class="text-white mont" href="contact.php?id=<?php echo $user_idx; ?>" style="font-size: 14px;">Back</a>
     </div><br/><br/>
   <div class="col-xl-4 col-lg-4 col-md-7 col-sm-10 mx-auto">
        <div class="card">
        <span class="position-absolute" style="padding-left: 33%; margin-top: -50px;"><img src="./<?php echo $image; ?>" class="rounded-circle img-thumbnail" style="width: 125px; height: 125px;" /></span>                 
        <div class="card-body" style="padding-left: 10px;">
        <br/><br/><center>
            <div style="padding-top: 35px;">
                <span class="mont" style="font-size: 16px;"><?php echo $fullname; ?></span> 
            </div>
            <div style="margin-top: 0px;">
                <span class="text-muted" style="font-size: 13px;"><?php echo $email; ?></span>
            </div>
            <div style="padding-top: 15px;">
                <span class="mont" style="font-size: 13px;"><?php echo $designation; ?>, <br/><?php echo $company; ?></span>
            </div>
             <div style="padding-top: 15px;">
                <span class="text-muted" style="font-size: 13px;">Remarks: "<?php echo $remarks; ?>"</span>
            </div><br/>
            <hr/>
            <div class="col-xl-10 col-lg-10 col-md-8 col-sm-7 mx-auto">
                <div class="row">
                    <div class="col">
                        <div class="d-grid gap-2">
                            <a class="btn btn-primary rounded-pill" href="mailto:<?php echo $email; ?>"><strong>Email</strong></a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-grid gap-2">
                            <a class="btn btn-outline-secondary rounded-pill" href="#" data-bs-toggle="modal" data-bs-target="#connectModal"><strong>Save</strong></a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-grid gap-2">
                            <a class="btn btn-outline-secondary rounded-pill" href="tel:<?php echo $phone; ?>"><strong>Call</strong></a>
                        </div>
                    </div>
                </div>  
                </div></div>
            </div>
        </div> <!-- end of card --><br/>
   </div> <!-- end of core div class -->
<?php include('footer.php'); ?>