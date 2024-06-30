<?php
    session_start();
    if(isset($_SESSION['logged-in'])){
        header('Location: index.php');
        exit();
    }
?>
<?php include 'header.php';?>

<div class="container-fluid">
<br/><br/><br/>

<div class="col-lg-4 mx-auto">
<!--<center><span class="coustard text-white" style="font-size: 29px;"><i class="bi bi-person-badge"></i> &nbsp;beepty</span></center><br/>-->
<form method="post" action="loginValidation.php">
<div class="card" style="">
  <div class="card-body" style="padding:40px;">
    <center><h5 class="card-title">Login to your account</h5></center>
    
   <div class="mb-3" style="padding-top: 10px;">
 
  <input type="text" class="form-control" id="login" name="login" placeholder="Enter email" required />
</div>

<div class="mb-3">
 
  <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required />
</div>
<div class="d-grid gap-2" style="padding-top: 10px;">
 <button type="submit" class="btn btn-dark">Continue</button>
 </div>
 <hr/>
 <center><span style="font-size: 13px;"><a href="#">Forgot your password?</a> - <a href="#">Sign up for an account</a></span></center>
 </form>
 
        <?php
            if(isset($_SESSION['loginError'])){
                echo $_SESSION['loginError'];
            }
        ?>
        </div>
    </div>
</div> 
</div>
