<?php
 session_start();
    include 'connect/server.php';

    require 'PHPMailer/PHPMailerAutoload.php';
   $mail = new PHPMailer();

    $var_value_id = $_GET['varname'];

    if(empty($_SESSION["user_id"])){

        header("location: index"); 
    }

    if(empty($_SESSION["user_id"])){

        header("location: index"); 
    }

    if(empty($_SESSION["department_id"])){

        header("location: index"); 
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

if (isset($_POST['btn_save_roles'])) {

  $role=$_POST['role'];

   $sql= "SELECT * FROM user_roles WHERE role='$role' AND user_id='$var_value_id'";
                
      $result=mysqli_query($db,$sql);

      if (mysqli_num_rows($result)==0) {
          
          
$sql_save="INSERT INTO user_roles (user_id,role) VALUES ('$var_value_id','$role')";
            mysqli_query($db,$sql_save);

  $message="Saved";

}else if (mysqli_num_rows($result)!=0) {

  $message="Already Exist";

}

}
if(isset($_POST['btn_update_roles'])){
              $editid = $_POST['editid'];
              $name=$_POST['name'];
             
$sql = "UPDATE user_roles SET role='$role' WHERE id='$editid' ";
  mysqli_query($db,$sql);

  $message="Updated";

}
//Delete teacher    
if(isset($_POST['btn_delete_roles'])){
    $deleteid = $_POST['deleteid'];
    
    $sql = "DELETE FROM user_roles WHERE id='$deleteid' ";
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
        <?php include 'config/side_bar_settings.php'; ?>
    </aside>

    <div id="right-panel" class="right-panel">

        <?php include 'config/right_panel.php'; ?>

       <div class="content">
                <!--<div class="row">-->

                  <input type="submit" name="add" class="btn btn-info" value="Add New Role" data-toggle="modal" data-target="#add" style="width: 200px;"><br>
                  <label style="color: blue;"><?php echo $message; ?></label>

                  <div style="overflow-y: scroll; height:300px; margin-top: 0px;">
                    
                  

                  
                  
                  <div class="table-responsive" >  
                     <table class="table table-striped" id="employee_table">  
                          <tr>  
                               
                               <th>Role</th>
                                <th>Delete</th>
                          </tr> 
                          <?php 
                   $sql= "SELECT * FROM user_roles WHERE user_id='$var_value_id'";
              $result=mysqli_query($db,$sql);

              if (mysqli_num_rows($result)!=0) {
                  
                  while ($row=mysqli_fetch_assoc($result)) {
                      
                      $id=$row['id'];
                       $role=$row['role'];
                      ?>
                  <tr>
                     <td><?php echo $role;?></td>
                      <td>
                        <a href="#delete<?php echo $id;?>" data-toggle="modal"><input class="btn btn-danger" type="submit" name="delete" value="Delete"></a>
                      </td>
                      
                     </tr> 


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
                                <div class="alert alert-danger">Are you Sure you want Delete <strong><?php echo $role; ?>?</strong></p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="btn_delete_roles" class="btn btn-danger">YES</button>
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



                </div>
<?php
                include 'footer.php';
                ?>
     </div>

     

     <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header" style="background: #398AD7; color: #fff;">
      </div>

      <div class="modal-body">
        <div class="form-group">
          <label>Select Role</label>
          <select name="role" class="form-control" required>
            <option></option>
            <option value="Upload Document">Upload Document</option>
            <option value="Read Document">Read Document</option>
            <option value="Delete Document">Delete Document</option>
            <option value="Share Document">Share Document</option>
            <option value="Comment">Comment</option>
            <option value="View Shared Document">View Shared Document</option>
            <option value="View Contact List">View Contact List</option>
            <option value="View System Logs">View System Logs</option>
            <option value="Admin">Admin</option>
            <option value="Super Admin">Super Admin</option>
          </select>
    </div>
  </div>

    <div class="modal-footer">
      <button type="submit" name="btn_save_roles" class="btn btn-primary">Save</button>
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