<?php
 session_start();
    include 'connect/server.php';

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

if (isset($_POST['save'])) {

  $title=$_POST['title'];
  $start_date=$_POST['start_date'];
  $end_date=$_POST['end_date'];
  $description=$_POST['description'];


$sql="INSERT INTO calendar_events (title,start_date,end_date,description) VALUES ('$title','$start_date','$end_date','$description')";
            mysqli_query($db,$sql);
if($sql){
  $message="Saved";
}
else{
  $message= "Not Saved";
}
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
        <input type="submit" name="add" class="btn btn-info" value="Add New Calendar" data-toggle="modal" data-target="#add" style="width: 200px;"><br>

            <label style="color: blue;"><?php echo $message; ?></label>
	   		
	   	</div>
	   	 
       <div class="row" style="overflow-y: scroll; height:400px; margin-top: 0px;">
        <div class="table-responsive" >  

          <table class="table table-striped table-bordered" id="employee_data">  
            <thead> 
                          <tr>  
                               
                               <th>Title</th>
                               <th>Start Date</th>
                               <th>End Date</th>
                               <th>Description</th>
                               <th>Status</th>
                               <th>Edit</th>
                                <th>Delete</th>
                          </tr> 
                          <thead> 
                          <?php 
                   $sql= "SELECT * FROM calendar_events ORDER BY id DESC";
              $result=mysqli_query($db,$sql);

              if (mysqli_num_rows($result)!=0) {
                  
                  while ($row=mysqli_fetch_assoc($result)) {
                      
                      $id=$row['id'];
                       $title=$row['title'];
                       $start_date=$row['start_date'];
                       $end_date=$row['end_date'];
                       $description=$row['description'];
                       $ret_user_id=$row['user_id'];

                      
                  $date_checked_1=date_create($start_date);
                  $date_to_return_1=date_create($end_date); 

                  $interval = date_diff($date_checked_1, $date_to_return_1); 

                  $check_date_to_return=$interval->format('%a');

                  $date_checked_1=date_create($start_date);

                  $current_date_1=date_create($current_date);

                  $interval2 = date_diff($date_checked_1, $current_date_1); 

                  $check_date_returned=$interval2->format('%a');

                  $date_diff=$check_date_returned-$check_date_to_return;


                  $date_to_return_2=date_create($date_to_return);

                  $current_date_1=date_create($current_date);

                  $interval3 = date_diff($date_to_return_2, $current_date_1); 

                  $check_rem_days=$interval3->format('%a');


                      ?>
                  <tr>
                     <td><?php echo $title;?></td>
                     <td><?php echo $start_date;?></td>
                     <td><?php echo $end_date;?></td>
                     <td><?php echo $description;?></td>
                     <td>
                       <?php
                      if($date_diff>0){
                        ?>
                        <label style="color: red; font-weight: 900;"><?php echo "Done"; ?></label>
                        <?php
                      }
                      if($date_diff<=0){
                        ?>
                        <label style="color: blue; font-weight: 900;"><?php echo "Pending"; ?></label>
                        <?php
                      }
                      ?>
                     </td>
                     <td>
                      <?php
                      if($ret_user_id==$user_id){
                      ?>
                      <a href="#edit<?php echo $id;?>" data-toggle="modal"><input class="btn btn-info" type="submit" name="edit" value="Edit"></a>
                      <?php
                        }
                      ?>
                      </td>
                      <td>
                        <?php
                      if($ret_user_id==$user_id){
                      ?>
                        <a href="#delete<?php echo $id;?>" data-toggle="modal"><input class="btn btn-danger" type="submit" name="delete" value="Delete"></a>
                        <?php
                        }
                        ?>
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

                        
                    <input type="hidden" name="editid" class="form-control" value="<?php echo $id; ?>"><br>

                    <label>Event Title</label>
          <input type="text" name="title" class="form-control" value="<?php echo $title; ?>" required>
          <label>Start Date</label>
          <input type="date" name="start_date" class="form-control" value="<?php echo $start_date; ?>"  required>
          <label>End Date</label>
          <input type="date" name="end_date" class="form-control" value="<?php echo $end_date; ?>"  required>
          <label>Description</label>
          <input type="text" name="description" class="form-control" value="<?php echo $description; ?>"  required>
                        
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
                                <div class="alert alert-danger">Are you Sure you want Delete <strong><?php echo $title; ?>?</strong></p>
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
          <label>Event Title</label>
          <input type="text" name="title" class="form-control" placeholder="Title" required>
          <label>Start Date</label>
          <input type="date" name="start_date" class="form-control" required>
          <label>End Date</label>
          <input type="date" name="end_date" class="form-control" required>
          <label>Description</label>
          <input type="text" name="description" class="form-control" placeholder="Description" required>
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
<script>  
 $(document).ready(function(){  
      $('#employee_data').DataTable();  
 });  
 </script> 