<?php
 session_start();
    include 'connect/server.php';


  require 'PHPMailer/PHPMailerAutoload.php';
   $mail = new PHPMailer();

    global $message,$message_email;

    date_default_timezone_set('Africa/Nairobi');
 $current_date = date('d/m/Y h:i:s a', time());

      if (isset($_POST['login'])) {

        $email=$_POST['email'];
        $password=$_POST['password'];   
         $enc_password=md5($password);

$sql= "SELECT * FROM users WHERE email='$email'"; 
         //$sql= "SELECT * FROM users WHERE email='$email' and password='$enc_password'";  
       $stmt=mysqli_query($db,$sql);

        //if (sqlsrv_num_rows($result)!=0) {
                  
                  $row=mysqli_fetch_array($stmt);

                    $user_id=$row['id'];
                     $name=$row['name'];
                    $department_id=$row['department_id'];
                    $admin=$row['admin'];
                    $status=$row['status'];

                    $_SESSION['user_id']=$user_id;
                   $_SESSION['department_id']=$department_id;
                   $_SESSION['name']=$name;
                   $_SESSION['admin']=$admin;


                    //echo $name;

                    //echo $name;

                    /*if($status==1){

                      $_SESSION['user_id']=$user_id;
                   $_SESSION['department_id']=$department_id;
                   $_SESSION['name']=$name;
                   $_SESSION['admin']=$admin;

                   //$sql_save_log="INSERT INTO system_logs (user_id,department_id,activity,date_logged) VALUES ('$user_id','$department_id','Login','$current_date')";
           // sqlsrv_query($db,$sql_save_log);*/

                    header("location: dashboard.php"); 

                   /* }else if($status==0){
                       $message="You're not active!";
                    }*/
      
  
//}if (sqlsrv_num_rows($result)==0) {
  //  $message="Enter Corect Credentials!";
//}

      
}

if (isset($_POST['btn_forgot_password'])) {

  $email=$_POST['email'];


  $sql= "SELECT * FROM users WHERE email='$email'";  
       $result=mysqli_query($db,$sql);

        if (mysqli_num_rows($result)!=0) {
                  

  $password=rand(1000,10000);
  $enc_password=md5($password);
 $mailto = $email;
    $mailSub = 'EDMS Reset Password';
    $mailMsg = "You have reset your password \n Login using your email and password below: \n".$password."";

   
   $mail ->IsSmtp();
   $mail ->SMTPDebug = 0;
   $mail ->SMTPAuth = true;
   //$mail ->SMTPSecure = 'ssl';
   $mail ->SMTPSecure = 'tsl';
   $mail ->Host = "smtp.gmail.com";
   $mail ->Port = 587; // or 587 or 465
   //$mail ->IsHTML(true);
   $mail ->Username = "linus.too12@gmail.com";
   $mail ->Password = "Linus@27";
   $mail ->SetFrom("linus.too12@gmail.com");
   $mail ->Subject = $mailSub;
   $mail ->Body = $mailMsg;
   $mail ->AddAddress($mailto);

   if($mail->Send()&& $db)
   {

$sql_update = "UPDATE users SET password='$enc_password' WHERE email='$email' ";
mysqli_query($db,$sql_update);

     $message_email= "Password Reset, check your email ".$email."";
   }
   else
   {
       $message_email= "Enter valid email";
   }


 }if (mysqli_num_rows($result)==0) {

   $message_email= "The Email you entered does not exist on the system";

 }

}
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <?php include 'config/head.php'; ?>
</head>
<body>
    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

            <div class="animated fadeIn">

              <div class="container">
             
                <div class="row">

                   
                        <!-- Left Block -->
                        <div class="col-md-12">

                            <div class="card" style="margin-top: 20px;">
                                
                                <div class="card-body" style="background-color: #f5f5f5;">

                                    
                                        
              <div class="display-container">
                <div class="row">

                  <div class="col-md-2">
                   </div>
                <div class="col-md-8">
                  <center>
                    <img src="images/coat_of_arms_kenya.png"><br>
<label style="font-weight: 900;">COUNTY ASSEMBLY OF SIAYA</label>
                  </center>

                  <form method="POST">
              <input type="email" name="email" class="form-control" placeholder="Email" required value="info@ca.com"><br>
              <label></label>
              <input type="password" name="password" class="form-control" placeholder="Password" ><br>
              <div class="row">

                <div class="col-md-4">
                  <input type="submit" name="login" class="btn btn-info" value="Log In">
                </div>

                <div class="col-md-4">
                  <a class="nav-link" href="#forgot_password" data-toggle="modal" style="color: blue;">
             Forgot Password?
            </a>
                </div>
                
              </div>
              
            </form>

            <label style="color: red;"><?php echo $message; ?></label><br>

            <label style="color: green;"><?php echo $message_email; ?></label><br>

            

            <hr> 

            <center>
              Copyright &copy; <?php echo date("Y"); ?> - County Assembly of Siaya - All Rights Reserved
            </center>
                </div>

                <div class="col-md-2">
                   </div>
                
              </div>

              </div>

                            </div>

                        </div>
                        </div>
                        
                        </div>


                        

                </div>


    </div>

    <div class="modal fade" id="forgot_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data">
        <div class="modal-header" style="background: #398AD7; color: #fff;"><!--398AD7--><!--08B6CE-->
  
        <h5>RESET PASSWORD</h5>
      </div>

      <div class="modal-body">
        <div class="form-group">
        
        <div class="form-group">

          <input type="email" name="email" class="form-control" placeholder="Enter Email" required>


    </div>

    <div class="modal-footer">
      <button type="submit" name="btn_forgot_password" class="btn btn-primary">Reset Password</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>

    </form>
  </div>
    </div>
  </div>

    


    <?php include 'config/scripts.php'; ?>

</body>
</html>
