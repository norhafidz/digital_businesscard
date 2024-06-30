<?php
  require_once('connect.php');
/*
  $sql="SELECT * FROM USER WHERE id=".$_GET['id'];
  $result=mysql_fetch_row(mysql_query($sql));*/

   $name =  'Mohd Norhafidz Nordin';
   $company_name = 'UEM Sunrise Berhad';
   $designation = 'Digital Innovation Manager';
   $email = 'hafidz.nordin@uemsunrise.com';
   $mobile_no = '0197496825';

  // define here all the variable like $name,$image,$company_name & all other
  header('Content-Type: text/x-vcard');  
  header('Content-Disposition: inline; filename= "'.$name.'.vcf"');  

  /*if($image!=""){ 
    $getPhoto               = file_get_contents($image);
    $b64vcard               = base64_encode($getPhoto);
    $b64mline      yyu         = chunk_split($b64vcard,74,"\n");
    $b64final               = preg_replace('/(.+)/', ' $1', $b64mline);
    $photo                  = $b64final;
  }*/
  $vCard = "BEGIN:VCARD\r\n";
  $vCard .= "VERSION:4.0\r\n";
  $vCard .= "FN:" . $name . "\r\n";
  $vCard .= "TITLE:" . $company_name . "\r\n";
  $vCard .= "ROLE:" . $designation . "\r\n";
  $vCard .= "PHOTO;JPEG:http://task0525.epizy.com/card/img/panda.png\r\n"; 

  if($email){
    $vCard .= "EMAIL;TYPE=internet,pref:" . $email . "\r\n";
  }
  if($getPhoto){
    $vCard .= "PHOTO;ENCODING=b;TYPE=JPEG:";
    $vCard .= $photo . "\r\n";
  }

  if($mobile_no){
    $vCard .= "TEL;TYPE=work,voice:" . $mobile_no . "\r\n"; 
  }

  $vCard .= "END:VCARD\r\n";
  echo $vCard;

?>