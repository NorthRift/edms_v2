<?php
 session_start();
    include 'connect/server.php';

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
    if(isset($_SESSION["department_id"])){
     $_SESSION['department_id'];
     $department_id=$_SESSION['department_id'];
    }

    if(isset($_SESSION["name"])){
     $_SESSION['name'];
     $name=$_SESSION['name'];
    }

    if(isset($_SESSION["admin"])){
     $_SESSION['admin'];
     $admin=$_SESSION['admin'];
    }

  date_default_timezone_set('Africa/Nairobi');
$date_saved = date('d/m/Y h:i:s a', time());

    global $message;

if(isset($_POST['btn_approve'])){
    $doc_id = $_POST['doc_id'];

    $sql_update = "UPDATE documents SET status='1' WHERE id='$doc_id' ";
mysqli_query($db,$sql_update);

$message="Approved"; 
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
	   	</div>
	   	 

	   	<div class="row" style="overflow-y: scroll; height:450px; margin-top: 0px;">
             <div class="table-responsive" >  
                     <table id="employee_data" class="table table-striped table-bordered">  
                          <thead>  
                          <tr>  
                               <th>Doc Name</th>
                               <th>Category</th>
                               <!--<th>Department</th>-->
                               <th>Date Uploaded</th>
                               <th>Open</th>
                               <th>Delete</th>
                               <th>Approve</th>

                          </tr>
                          </thead> 
                          <?php
                   $sql= "SELECT * FROM documents WHERE department_id='$department_id' AND status=0 ORDER BY id DESC ";
              $result=mysqli_query($db,$sql);

              if (mysqli_num_rows($result)!=0) {
                  
                  while ($row=mysqli_fetch_assoc($result)) {
                      
                      $id=$row['id'];
                      $doc_un_id=$row['doc_un_id'];
                       $doc_name=$row['doc_name'];
                       $doc_name_raw=$row['doc_name_raw'];
                      $category_id=$row['category_id'];
                      $dep_id=$row['department_id'];
                      $date_saved=$row['date_saved'];

                      $sql_category= "SELECT * FROM category WHERE id='$category_id'";
                      $result_category=mysqli_query($db,$sql_category);

                      if (mysqli_num_rows($result_category)!=0) {
                          
                          while ($row_category=mysqli_fetch_assoc($result_category)) {
                              
                              $category_name=$row_category['name'];
                            }
                          }

                           /*$sql_department= "SELECT * FROM department WHERE id='$dep_id'";
                      $result_department=mysqli_query($db,$sql_department);

                      if (mysqli_num_rows($result_department)!=0) {
                          
                          while ($row_department=mysqli_fetch_assoc($result_department)) {
                              
                              $department_name=$row_department['name'];
                            }
                          }*/
                      ?>
                  <tr>
                       <td><?php echo $doc_name_raw;?></td>
                       <td><?php echo $category_name;?></td>
                       <td><?php echo $date_saved;?></td>
                       <td>
                      <a href="#edit<?php echo $id;?>" data-toggle="modal">
                        <button class="btn btn-info"><i class="fa fa-folder-open"></i> Open</button>
                      </a>
                      </td>
                      <td>
                          <a href="#delete<?php echo $id;?>" data-toggle="modal"><img src="images/delete_icon.png" style="width: 30px;"></a>
                        </td>
                      <td>
                        <a href="#approve<?php echo $id;?>" data-toggle="modal"><i class="fa fa-check"></i> Approve</a>
                      </td>
                      
                     </tr> 


                      <div id="edit<?php echo $id; ?>" class="modal fade" role="dialog">
            <form method="post">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #398AD7; color: #fff;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Read</h4>
                        </div>
                        <div class="modal-body">
                    
          <input type="hidden" name="editid" class="form-control" value="<?php echo $id; ?>">
                    
                        <iframe src="uploads/pdf/<?php echo $doc_name;?>" width="100%" height="450px">
                          
                        </iframe>
             

              
          	</div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
                    </div>
                </div>
              </form>
        </div> 

        <div id="approve<?php echo $id; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <form method="post">
                    
                    <div class="modal-content">

                        <div class="modal-header" style="background: #398AD7; color: #fff;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Approve</h4>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="doc_id" value="<?php echo $id; ?>">
                            <label>Do you really want to approve this document?</label>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="btn_approve" class="btn btn-success">YES</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                            </div>
                        </div>
                </form>
                </div>
            </div>  


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
                            <input type="hidden" name="doc_name" value="<?php echo $doc_name; ?>">
                            <p>
                                <div class="alert alert-danger">Are you Sure you want Delete <strong><?php echo $doc_name_raw; ?>?</strong></p>
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

	    <div class="modal fade" id="add_document" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data">
        <div class="modal-header" style="background: #398AD7; color: #fff;"><!--398AD7--><!--08B6CE-->
  
        <h5>DOCUMENT UPLOAD</h5>
      </div>

      <div class="modal-body">
        <div class="form-group">

          <input type="file" name="doc_name[]" id="file" multiple required>
          <br>
          <label>Enter Category</label>
        
        <div class="form-group">
                  <?php 
                    $sqld= "SELECT * FROM category WHERE department_id='$department_id'";
                    $resultd = mysqli_query($db, $sqld);
                    ?>
                    <select name="category" class="form-control" required>
                      <option></option>
                  <?php while($rowd = mysqli_fetch_array($resultd)):;?>

                  <option value="<?php echo $rowd['id'];?>"><?php echo $rowd['name'];?></option>

                  <?php endwhile;?>

                    </select>
                          <?php

                    ?>
                </div>

                <label>Check if Approved</label> <input type="checkbox" name="status" value="1">


    </div>

    <div class="modal-footer">
      <button type="submit" name="save" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>

    </form>
  </div>
    </div>
  </div>

        
    </div>
    
   <?php include 'config/scripts.php'; ?>

</body>
</html>
<script>  
 $(document).ready(function(){  
      $('#employee_data').DataTable();  
 });  
 </script>