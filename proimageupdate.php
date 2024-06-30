<?php
    session_start();
    if(!(isset($_SESSION['logged-in']))){
        header('Location: login.php');
        exit();
    }
    
    require_once "connect.php";

    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if($connection->connect_errno!=0){
        echo "Error: ".$connection->connect_errno . "<br>";
        echo "Description: " . $connection->connect_error;
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $user = $_SESSION['user'];
    $preferred_name = $_SESSION['preferred_name'];
    $email = $_SESSION['email'];
    $id = $_GET['id'];


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
                    // Connect to the database
                    // Check if the connection was successful
                    if($connection) {
                        
                        // check whether user have existing image
                        $query_ImageExist = mysqli_query($connection, "SELECT * from users where id='$user_id'");
                        $count_ImageExist = mysqli_num_rows($query_ImageExist);

                        if ($count_ImageExist <= 0) {
                            header('location:settings.php');
                        } else {

                            $get_Image = mysqli_fetch_array($query_ImageExist);
                            $user_Image = $get_Image['image'];

                            if (($user_Image == NULL) or ($user_Image == '') or (!isset($user_Image))) {
                                goto SQL;
                            } else {
                                if (!unlink($user_Image)) {
                                    echo "Error deleting Profile Image";
                                    } else {
                                    goto SQL2;
                                }
                            }

                        }

                        // Prepare an SQL statement
                        SQL:
                        SQL2:
                        $sql = "UPDATE users SET image = '$file_destination' where id='$user_id'";
                        // Execute the SQL statement
                        if(mysqli_query($connection, $sql)) {
                           header ('location: settings.php');
                        } else {
                            echo "Error uploading image";
                        }
                        // Close the database connection
                        mysqli_close($connection);
                    } else {
                        echo "Error connecting to database";
                    }
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
?>
