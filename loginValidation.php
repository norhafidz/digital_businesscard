<?php

session_start();
require_once "connect.php";

$connection = new mysqli($host, $db_user, $db_password, $db_name);

if($connection->connect_errno!=0){
    echo "Error: ".$connection->connect_errno . "<br>";
    echo "Description: " . $connection->connect_error;
}
else {
    $login = mysqli_real_escape_string($connection, $_POST['login']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    
    $sql = "SELECT * FROM users WHERE login='$login' AND password='$password'";
    
    if($result = $connection->query($sql)){
        $usersCount = $result->num_rows;
        if($usersCount>0){
            $_SESSION['logged-in'] = true;
            $row = $result->fetch_assoc();
            $user = $row['login'];
            $preferred_name = $row['preferred_name'];
            $user_id = $row['id'];
            $user_level = $row['u_level'];
            $email = $row['email'];
            
            $result->free_result();
            
            $_SESSION['user'] = $user; 
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_level'] = $user_level;
            $_SESSION['preferred_name'] = $preferred_name;
            $_SESSION['email'] = $email;
           
            
            unset($_SESSION['loginError']);
            header('Location: index.php');
        }
        else{
            $_SESSION['loginError'] = '<span class="error-msg">Invalid inputs.</span>';
            header('Location: login.php');
        }
    }
    $connection->close();
}

?>