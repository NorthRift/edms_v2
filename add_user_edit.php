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

    if(empty($_SESSION["department_id"])){

        header("location: index.php"); 
    }

    if(isset($_SESSION["user_id"])!=''){
     $_SESSION['user_id'];
     $user_id=$_SESSION['user_id'];
    }
    if(isset($_SESSION["name"])!=''){
     $_SESSION['name'];
     $user_name=$_SESSION['name'];
    }

    if(isset($_SESSION["department_id"])){
     $_SESSION['department_id'];
     $department_id=$_SESSION['department_id'];
    }

    if(isset($_SESSION["admin"])){
     $_SESSION['admin'];
     $admin=$_SESSION['admin'];
    }

  date_default_timezone_set('Africa/Nairobi');
$date_saved = date('d/m/Y h:i:s a', time());

    global $message;

if (isset($_POST['save'])) {

  $post_department_id=$_POST['department'];
  $name=$_POST['name'];
  $phone_no=$_POST['phone_no'];
  $email=$_POST['email'];

   $sql_department= "SELECT * FROM department WHERE id='$post_department_id'";
    $result_department=mysqli_query($db,$sql_department);
    if (mysqli_num_rows($result_department)!=0) {
        while ($row_department=mysqli_fetch_assoc($result_department)) {
            
            $department_name=$row_department['name'];
          }
        }


  $password=rand(1000,10000);
  $enc_password=md5($password);
 $mailto = $email;
    $mailSub = 'EDMS Password';
    $mailMsg = "You have been added into EDMS system ".$department_name." department \n Login using your email and password below: \n".$password."";

   
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

$sql="INSERT INTO users (department_id,name,phone_no,email,password) VALUES ('$post_department_id','$name','$phone_no','$email','$enc_password')";
            mysqli_query($db,$sql);

     $message= "User Saved & Mail Sent";
   }
   else
   {
       $message= "User Not Saved & Enter valid Email";
   }

}


if(isset($_POST['update_acc'])){
$editid = $_POST['editid'];
$post_department_id=$_POST['department'];
$name=$_POST['name'];
  $phone_no=$_POST['phone_no'];
  $email=$_POST['email'];


$sql = "UPDATE users SET name='$name',phone_no='$phone_no',email='$email',department_id='$post_department_id' WHERE id='$editid' ";

mysqli_query($db,$sql);

$message="Updated";        

}

if(isset($_POST['btn_disable_user'])){
  $status_id = $_POST['status_id'];

  $sql_update = "UPDATE users SET status='0' WHERE id='$status_id'";

mysqli_query($db,$sql_update);

$message="User Disabled";


}



if(isset($_POST['btn_enable_user'])){
  $status_id = $_POST['status_id'];

  $sql_update = "UPDATE users SET status='1' WHERE id='$status_id'";

mysqli_query($db,$sql_update);

$message="User Enabled";


}

  //Delete teacher    
if(isset($_POST['delete_acc'])){
  $deleteid = $_POST['deleteid'];
  
  $sql = "DELETE FROM users WHERE id='$deleteid' ";
  mysqli_query($db,$sql);
  $message="Deleted";
}


if(isset($_POST['enable_admin'])){

$enable_admin_id = $_POST['enable_admin_id'];

$sql_update = "UPDATE users SET admin='1' WHERE id='$enable_admin_id' ";
mysqli_query($db,$sql_update);

$message="Updated";        

}

if(isset($_POST['disable_admin'])){

$disable_admin_id = $_POST['disable_admin_id'];

$sql_update = "UPDATE users SET admin='0' WHERE id='$disable_admin_id' ";
mysqli_query($db,$sql_update);

$message="Updated";        

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
        <?php include 'config/side_bar_settings.php'; ?>
    </aside>

    <div id="right-panel" class="right-panel">

        <?php include 'config/right_panel.php'; ?>

       <div class="content">

      <div class="row">
      <input type="submit" name="add" class="btn btn-info" value="Add New User" data-toggle="modal" data-target="#add">
            <br>
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
                               
                               <th>Edit</th>
                               <th>Action</th>
                                <th>Delete</th>
                                <th>Roles</th>
                          </tr> 
                          <?php 

                   $sql= "SELECT * FROM users ORDER BY id DESC";
                 
              $result=mysqli_query($db,$sql);

              if (mysqli_num_rows($result)!=0) {
                  
                  while ($row=mysqli_fetch_assoc($result)) {
                      
                      $id=$row['id'];
                       $name=$row['name'];
                       $phone_no=$row['phone_no'];
                       $email=$row['email'];
                       $ret_department_id=$row['department_id'];
                       //$ret_admin=$row['admin'];
                       $user_status=$row['status'];

                       $sql_department= "SELECT * FROM department WHERE id='$ret_department_id'";
                    $result_department=mysqli_query($db,$sql_department);
                    if (mysqli_num_rows($result_department)!=0) {
                        while ($row_department=mysqli_fetch_assoc($result_department)) {
                            
                            $dep_name=$row_department['name'];
                          }
                        }
                      ?>
                  <tr>
                     <td><?php echo $name;?></td>
                     <td><?php echo $dep_name;?></td>
                     <td><?php echo $phone_no;?></td>
                     <td><?php echo $email;?></td>
                     <td>
                      <a href="#edit<?php echo $id;?>" data-toggle="modal"><input class="btn btn-info" type="submit" name="edit" value="Edit"></a>
                      </td>

                      <td>
                        <?php
                        if($user_status==1)
                        {
                        ?>
                        <form method="POST">
                          <input type="hidden" name="status_id" value="<?php echo $id; ?>">
                          <input type="submit" name="btn_disable_user" value="Disable User" class="btn btn-warning">
                        </form>
                        <?php
                        }
                        if($user_status==0)
                        {
                        ?>
                        <form method="POST">
                          <input type="hidden" name="status_id" value="<?php echo $id; ?>">
                          <input type="submit" name="btn_enable_user" value="Enable User" class="btn btn-success">
                        </form>
                        <?php
                        }
                        ?>
                      </td>

                      <td>
                        <a href="#delete<?php echo $id;?>" data-toggle="modal"><input class="btn btn-danger fa fa-trash" type="submit" name="delete" value="Delete"></a>
                      </td>
                      <td>
                        <a href="user_roles.php?varname=<?php echo $id ?>"><button type="submit" name="btn_share_now" class="btn btn-default"><i class="fa fa-cog"></i> Roles</button></a>
                      </td>
                      
                     </tr> 

                     <!-- Edit Class -->
        <div id="edit<?php echo $id; ?>" class="modal fade" role="dialog">
            <form method="post">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #398AD7; color: #fff;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit</h4>
                        </div>
                        <div class="modal-body">

                    <input type="hidden" name="editid" class="form-control" value="<?php echo $id; ?>">
                    <label>Select Department</label>
                    <div class="form-group">
                      <?php
                      $sql_dep= "SELECT * FROM department";
                    $result_dep=mysqli_query($db,$sql_dep);
                    if (mysqli_num_rows($result_dep)!=0) {
                      ?>
                      <select name="department" class="form-control" required>
                        <option value="<?php echo $ret_department_id; ?>"><?php echo $dep_name; ?></option>
                      <?php
                        while ($row_dep=mysqli_fetch_assoc($result_dep)) {
                          
                            ?>
                            
                            <option value="<?php echo $row_dep['id']; ?>"><?php echo $row_dep['name']; ?></option>
                            <?php
                          }
                          ?>
                        </select>
                          <?php
                        }
                      ?>
                    </div>

                    <label>Enter Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
              <label>Enter Phone No</label><input type="text" name="phone_no" class="form-control" value="<?php echo $phone_no; ?>" required>
              <label>Enter Email</label><input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                        
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="update_acc">Update  </button>
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

      <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data">
        <div class="modal-header" style="background: #398AD7; color: #fff;">
      </div>

      <div class="modal-body">
        <div class="form-group">
          <label>Select Department</label>
                    <div class="form-group">
                  <?php 
                    $sqld= "SELECT * FROM department";
                    $resultd = mysqli_query($db, $sqld);
                    ?>
                    <select name="department" class="form-control" required>
                      <option></option>
                  <?php while($rowd = mysqli_fetch_array($resultd)):;?>

                  <option value="<?php echo $rowd['id'];?>"><?php echo $rowd['name'];?></option>

                  <?php endwhile;?>

                    </select>
                          <?php

                    ?>
                </div>
          <label>Enter Name</label><input type="text" name="name" class="form-control" placeholder="Enter name" required><br>
          <label>Enter Phone No</label><input type="text" name="phone_no" class="form-control" placeholder="Enter Phone number" required><br>
          <label>Enter Email</label><input type="email" name="email" class="form-control" placeholder="Enter email" required>
    </div>
  </div>

    <div class="modal-footer">
      <button type="submit" name="save" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>

    </form>
  </div>
    </div>
  </div>
        
    </div><!--end of right panel-->
    
   <?php include 'config/scripts.php'; ?>

</body>
</html>
 <?php include 'config/search_script.php'; ?>