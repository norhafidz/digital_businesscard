<?php
 
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

// Authentication
$api_key = "AIzaSyAbJile7HLeDbUCuWQOPT-pHtCcCtzpTOo";
 
// Chanel ID (National Geographic)
$chann_id = "UCN_iywClaF6a2zLwU920fbw";
         
//reading the channel file containing required data in JSON format
$subscribers = file_get_contents('https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.$chann_id.'&key='.$api_key);
$views = file_get_contents('https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.$chann_id.'&key='.$api_key);
 
// Decoding the JSON string and converting it into PHP variables.
$response = json_decode($subscribers, true );
$response2 = json_decode($views, true );
 
// Getting the integer value from the variables of Subscribers and Lifetime views 
$subscribersCount = intval($response['items'][0]['statistics']['subscriberCount']);
$viewsCount = intval($response2['items'][0]['statistics']['viewCount']);  

$rand = rand(1,10); 


?>
<div class="container-fluid">
<br/><br/><br/><br/><br/><br/><br/>
    <div class="col-lg-3" style="margin:auto;">
        <div class="card">
         <span class="position-absolute" style="padding-left: 33%; margin-top: -50px;"><img src="./img/youtube.png" class="img-fluid rounded-circle img-thumbnail" style="width: 125px; height: 125px;" /></span>    
            <div class="card-body">
            <br/><br/><br/><center><h1>
                <?php 
                    echo $subscribersCount;
                ?></h1>Subscribers<br/><hr/>
                <small><?php echo date('M d, Y'); ?></small>
                </center>
            </div>
        </div>
<br/><br/>
<?php 

$query_CheckNum = mysqli_query($connection, "SELECT * from subs where id='1'");
$count_CheckNum = mysqli_num_rows($query_CheckNum);

if ($query_CheckNum <= 0) {
    Print '';
} else {

    $get_CheckNum = mysqli_fetch_array($query_CheckNum);
    $sub_Count = $get_CheckNum['sub'];

    if ($subscribersCount <= $sub_Count) {
        Print '';
    } elseif ($subscribersCount > $sub_Count) {

        $query_CheckAudio = mysqli_query($connection, "SELECT * from audio where id='$rand'");

        $get_myAudioFile = mysqli_fetch_array($query_CheckAudio);
        $myAudioFile = $get_myAudioFile['audio'];

        echo '<audio controls autoplay>
  <source src="./sound/'. $myAudioFile .'" type="audio/mpeg">
Your browser does not support the audio element.
</audio>';

        mysqli_query($connection, "UPDATE subs SET sub='$subscribersCount' where id='1'");
    }  if ($subscribersCount == $sub_Count) {
        Print '';
        
        } else {
        Print '';
    }
}

?>
    </div>
</div>