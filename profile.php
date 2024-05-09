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
if(isset($_POST['update_acc'])){
              $editid = $_POST['editid'];
              $name=$_POST['name'];
  $phone_no=$_POST['phone_no'];
  $email=$_POST['email'];
             
       $sql = "UPDATE users SET name='$name',phone_no='$phone_no',email='$email' WHERE id='$editid' ";
             
              mysqli_query($db,$sql);

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
                               <th>Phone no</th>
                               <th>Email</th>
                               <th>Edit</th>
                          </tr> 
                          <?php 
                   $sql= "SELECT * FROM users WHERE id='$user_id'";
              $result=mysqli_query($db,$sql);

              if (mysqli_num_rows($result)!=0) {
                  
                  while ($row=mysqli_fetch_assoc($result)) {
                      
                      $id=$row['id'];
                       $name=$row['name'];
                       $phone_no=$row['phone_no'];
                       $email =$row['email'];
                      ?>
                  <tr>
                     <td><?php echo $name;?></td>
                     <td><?php echo $phone_no;?></td>
                     <td><?php echo $email;?></td>
                     <td>
                      <a href="#edit<?php echo $id;?>" data-toggle="modal"><input class="btn btn-info" type="submit" name="edit" value="Edit"></a>
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

                    <label>Name</label>
          <input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required>
          <label>Phone numner</label>
          <input type="text" name="phone_no" class="form-control" value="<?php echo $phone_no; ?>"  required>
          <label>Email</label>
          <input type="email" name="email" class="form-control" value="<?php echo $email; ?>"  required>
                        
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
          <label>Enter Name</label><input type="text" name="name" class="form-control" required><br>
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