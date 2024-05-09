<?php
 session_start();
    include 'connect/server.php';

    require 'PHPMailer/PHPMailerAutoload.php';
   $mail = new PHPMailer();

    if(empty($_SESSION["user_id"])){

        header("location: index.php"); 
    }

    if(empty($_SESSION["user_id"])){

        header("location: index.php"); 
    }

    /*if(empty($_SESSION["department_id"])){

        header("location: index.php"); 
    }*/

    if(isset($_SESSION["user_id"])!=''){
     $_SESSION['user_id'];
     $user_id=$_SESSION['user_id'];
    }
    if(isset($_SESSION["admin"])){
     $_SESSION['admin'];
     $admin=$_SESSION['admin'];
    }


    if(isset($_SESSION["department_id"])){
     $_SESSION['department_id'];
     $department_id=$_SESSION['department_id'];
    }

   date_default_timezone_set('Africa/Nairobi');
$date_saved = date('d/m/Y h:i:s a', time());

$current_date=date("Y-m-d");

    global $message;

if (isset($_POST['btn_send_email'])) {

  $email=$_POST['email'];
  $message=$_POST['message'];

  $mailto = $email;
    $mailSub = 'EDMS Message';
    $mailMsg = "".$message."";

   
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

   if($mail->Send())
   {
     $message= "Mail Sent";
   }
   else
   {
       $message= "Enter valid Email";
   }


//$sql="INSERT INTO calendar_events (title,start_date,end_date,description) VALUES ('$title','$start_date','$end_date','$description')";
            //mysqli_query($db,$sql);


}


if(isset($_POST['update_acc'])){
              $editid = $_POST['editid'];
              $title=$_POST['title'];
  $start_date=$_POST['start_date'];
  $end_date=$_POST['end_date'];
  $description=$_POST['description'];
             
       $sql = "UPDATE calendar_events SET title='$title',start_date='$start_date',end_date='$end_date',description='$description' WHERE id='$editid' ";
             
              mysqli_query($db,$sql);

              $message="Updated";
          

}

  //Delete teacher    
        if(isset($_POST['delete_acc'])){
              $deleteid = $_POST['deleteid'];
              
              $sql = "DELETE FROM calendar_events WHERE id='$deleteid' ";
              mysqli_query($db,$sql);
              $message="Deleted";
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


    <aside id="left-panel" class="left-panel">
        <?php include 'config/side_bar.php'; ?>
    </aside>


    <div id="right-panel" class="right-panel">

        <?php include 'config/right_panel.php'; ?>


       <div class="content">

	   	

	   	<div class="row">

            <label style="color: blue;"><?php echo $message; ?></label>
	   		
	   	</div>
	   	 
       <div class="row" style="overflow-y: scroll; height:400px; margin-top: 0px;">
        <div class="table-responsive" >  

          <table class="table table-striped" id="employee_table">  
                          <tr>  
                               
                               <th>Name</th>
                               <th>Department</th>
                               <th>Phone No</th>
                                <th>Email</th>
                          </tr> 
                          <?php 
                   $sql= "SELECT * FROM users WHERE id !='$user_id'";
              $result=mysqli_query($db,$sql);

              if (mysqli_num_rows($result)!=0) {
                  
                  while ($row=mysqli_fetch_assoc($result)) {
                      
                       $id=$row['id'];
                       $dep_id=$row['department_id'];
                       $name=$row['name'];
                    //    $username=$row['username'];
                       $phone_no=$row['phone_no'];
                       $email=$row['email'];
                       $sql_department= "SELECT * FROM department WHERE id='$dep_id'";
                      $result_department=mysqli_query($db,$sql_department);

                      if (mysqli_num_rows($result_department)!=0) {
                          
                          while ($row_department=mysqli_fetch_assoc($result_department)) {
                              
                              $department_name=$row_department['name'];
                            }
                          }
                      ?>
                  <tr>
                     <td><?php echo $name;?></td>
                     <td><?php echo $department_name;?></td>
                     <td><?php echo $phone_no;?></td>
                     <td><?php echo $email;?></td>
                     <!--<td>
                      <a href="#message<?php //echo $id;?>" data-toggle="modal">
                          <button class="btn btn-warning"><i class="fa fa-envelope"></i>Email</button>
                        </a>
                      </td>-->
                      
                     </tr> 

                     <!-- Edit Class -->
        <div id="message<?php echo $id; ?>" class="modal fade" role="dialog">
            <form method="post">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #398AD7; color: #fff;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit</h4>
                        </div>
                        <div class="modal-body">
                        
                    <input type="hidden" name="editid" class="form-control" value="<?php echo $id; ?>">

                    <input type="hidden" name="name" class="form-control" value="<?php echo $name; ?>">                    <input type="hidden" name="email" class="form-control" value="<?php echo $email; ?>">
                    <label style="font-weight: 900;">Send email to <?php echo $name; ?></label><br>
                    <label>Type Message...</label>
                        <textarea name="message" class="form-control">
                          
                        </textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="btn_send_email">Send  </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
              </form>
        </div>        
<!--End of Edit Class-->

<!--Delete Class -->
        <div id="delete<?php echo $id; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <form method="post">
                    <!-- Modal content-->
                    <div class="modal-content">

                        <div class="modal-header" style="background: #398AD7; color: #fff;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Delete</h4>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="deleteid" value="<?php echo $id; ?>">
                            <p>
                                <div class="alert alert-danger">Are you Sure you want Delete <strong><?php echo $name; ?>?</strong></p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="delete_acc" class="btn btn-danger">YES</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                            </div>
                        </div>
                </form>
                </div>
            </div>
                     <?php
                   }
                 }
                 ?>
                                              

                        </table>  
                     
        </div>
        </div>

<?php
                include 'footer.php';
                ?>
	   </div>

        
    </div><!--end of right panel-->
    
   <?php include 'config/scripts.php'; ?>

</body>
</html>
 <?php include 'config/search_script.php'; ?>