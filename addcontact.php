<?php 
    // check whether the session is in tact, if no session, to redirect user to login page.
   /* session_start();
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

    // assign $user_id variable to session user id.
    $user_idx = $_GET['id'];

    if (($user_idx == '') or (!isset($user_idx))) {

        header('location:index.php');

    } else {
    
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
        $fullname = mysqli_real_escape_string($connection, $_POST['fullname']);
        $designation = mysqli_real_escape_string($connection, $_POST['designation']);
        $company = mysqli_real_escape_string($connection, $_POST['company']);
        $phone = mysqli_real_escape_string($connection, $_POST['phone']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $remarks = mysqli_real_escape_string($connection, $_POST['remarks']);
        $datetime = date('Y-m-d H:i:s');
        $datetimex = encrypt_decrypt('encrypt', $datetime);

        // Check if the form has been submitted
        if(isset($_POST['submit'])) {
        // Get the uploaded file information
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_size = $_FILES['image']['size'];
        $file_error = $_FILES['image']['error'];
        // Get the file extension
        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));
        // Allowed file extensions
        $allowed = array('jpg', 'jpeg', 'png');

        // Check if the uploaded file extension is allowed
        if(in_array($file_ext, $allowed)) {
            // Check if there was an error uploading the file
                if($file_error === 0) {
                    // Check if the file size is less than 2 MB
                    if($file_size <= 2097152) {
                        // Create a unique file name
                        $file_name_new = uniqid('', true) . '.' . $file_ext;
                        // Specify the path to upload the file
                        $file_destination = 'img/' . $file_name_new;
                        // Move the uploaded file to the specified folder
                        if(move_uploaded_file($file_tmp, $file_destination)) {
                            Print 'test';
                        } else {
                            echo "Error moving uploaded file";
                        }
                    } else {
                        echo "File size too large";
                    }
                } else {
                    echo "Error uploading file";
                }
            } else {
                echo "File extension not allowed";
            }
        }

        // check POST variables not equal to null
        if (($fullname == '') or (!isset($fullname)) or ($designation == '') or (!isset($designation)) or ($company == '') or (!isset($company)) or ($phone == '') or (!isset($phone)) or ($email == '') or (!isset($email)) or ($remarks == '') or (!isset($remarks))) {

        // execute this if POST variables is null
    echo "$fullname<br/>
    $designation<br/>
    $company<br/>
    $phone<br/>
    $email<br/>
    $remarks";
    
       // header('location:profile.php?id='. $user_idx .'');

        } else {
        // insert into users table details associated with variables. 

        mysqli_query($connection, "INSERT INTO contacts (fullname, designation, company, phone, email, remarks, datetime, user_id, image) values ('$fullname', '$designation', '$company', '$phone', '$email', '$remarks', '$datetime', '$user_id', '$file_destination')");
        header('location:profile.php?id='. $user_idx .'&tx='. $datetimex .'');

    // Close the database connection
    mysqli_close($connection);
        }
    }
}
?>