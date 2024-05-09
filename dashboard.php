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

if(isset($_POST['save'])){

  $category_id=$_POST['category'];


  if (isset($_POST['status'])) {

    $status=1;
  }else if (!isset($_POST['status'])){
    $status=0;
  }

 // Count total uploaded files
 $totalfiles = count($_FILES['doc_name']['name']);

 // Looping over all files
 for($i=0;$i<$totalfiles;$i++){

 /*if($totalfiles<=5){

for($i=0;$i<5;$i++){*/

 $filename = $_FILES['doc_name']['name'][$i];

 $ext = pathinfo($filename);

 $file_ext=$ext['extension'];

 $doc_name_x=md5($filename);

 $doc_name=$doc_name_x.".".$file_ext;

 $message="File: ".$doc_name;

// Upload files and store in database
if(move_uploaded_file($_FILES["doc_name"]["tmp_name"][$i],'uploads/pdf/'.$doc_name)){
    
    $sql_save="INSERT INTO documents (doc_name_raw,doc_name,user_id,category_id,department_id,date_saved,status) VALUES ('$filename','$doc_name','$user_id','$category_id','$department_id','$date_saved','$status')";

    mysqli_query($db,$sql_save);

     $sql_save_log="INSERT INTO system_logs (user_id,department_id,activity,date_logged) VALUES ('$user_id','$department_id','".$filename." Uploaded','$date_saved')";
            mysqli_query($db,$sql_save_log);
      $message="Data inserted successfully";
 
 }else{
    //$message="Error in uploading file - ".$_FILES['doc_name']['name'][$i]."";
    $message="Not uploaded because of error ".$_FILES['doc_name']['error'][$i]."";
  }

}
}

if(isset($_POST['delete_acc'])){
    $deleteid = $_POST['deleteid'];
    $doc_name = $_POST['doc_name'];

    $password=$_POST['password'];   
         $enc_password=md5($password);

    $sql_user="SELECT * FROM users WHERE id='$user_id' AND password='$enc_password'";

    $result_user=mysqli_query($db,$sql_user);
    

    if(mysqli_num_rows($result_user)!=0){

    $sql="SELECT * FROM documents WHERE id='$deleteid'";

    $result=mysqli_query($db,$sql);
    

    if(mysqli_num_rows($result)!=0){
        
        
        $filePath="uploads/pdf/".$doc_name;
    
        unlink($filePath);
    
    $sql_delete = "DELETE FROM documents WHERE id='$deleteid'";
    mysqli_query($db,$sql_delete);

    $sql_save_log="INSERT INTO system_logs (user_id,department_id,activity,date_logged) VALUES ('$user_id','$department_id','".$doc_name." Deleted','$date_saved')";
            mysqli_query($db,$sql_save_log);

    $message="Deleted";
  }

}elseif(mysqli_num_rows($result_user)==0){
  $message="Enter Correct Password";
}

}

if(isset($_POST['btn_select'])){
    $report_type = $_POST['report_type'];

    if($report_type=="Document Upload"){
      header("location: report_document_upload.php");
    }
    if($report_type=="System Logs"){
      header("location: report_system_logs.php");
    }
}

if(isset($_POST['btn_read_document'])){
    $doc_id = $_POST['doc_id'];
    $doc_name = $_POST['doc_name'];

    $_SESSION['doc_id']=$doc_id;
    $_SESSION['doc_name']=$doc_name;

    header("location: read_document.php"); 

}

if(isset($_POST['btn_open_chat'])){
    $doc_id = $_POST['doc_id'];
    $doc_name = $_POST['doc_name'];

    $_SESSION['doc_id']=$doc_id;
    $_SESSION['doc_name']=$doc_name;

    header("location: chat_room.php"); 

}
if(isset($_POST['btn_share_now'])){
    $doc_id = $_POST['doc_id'];
    $doc_name = $_POST['doc_name'];

    $_SESSION['doc_id']=$doc_id;
    $_SESSION['doc_name']=$doc_name;

    header("location: share_documents_now.php"); 

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
	   		<div class="col-md-2">
          <?php
          $sql_role= "SELECT * FROM user_roles WHERE user_id='$user_id' AND (role='Upload Document' OR role='Super Admin')"; 
              $result_role=mysqli_query($db,$sql_role);
              if (mysqli_num_rows($result_role)!=0) {
          ?>
	   			<input type="submit" name="add_document" class="btn btn-info" value="Add New Document" data-toggle="modal" data-target="#add_document"> 
          <?php
          }
        ?>
	   		</div>
        

        <div class="col-md-3">
        <label style="color: blue;"><?php echo $message; ?></label>
      </div>
	   		
	   	</div>
	   	 

	   	<div class="row" style="overflow-y: scroll; height:410px; margin-top: 0px;">
             <div class="table-responsive" >  
                     <table id="employee_data" class="table table-striped table-bordered">  
                           <thead> 
                          <tr>  
                               <th>Doc Name</th>
                               <th>Category</th>
                               <!--<th>Department</th>-->
                               <th>Date Uploaded</th>
                               <th>Read</th>
                               <th>Comment</th>
                               <th>Share</th>
                               <th>Delete</th>
                          </tr>
                        </thead>
                          <?php

                   $sql= "SELECT * FROM documents WHERE department_id='$department_id' AND status='1' ORDER BY id DESC";
              $result=mysqli_query($db,$sql);

              if (mysqli_num_rows($result)!=0) {
                  
                  while ($row=mysqli_fetch_assoc($result)) {
                      
                      $id=$row['id'];
                      $doc_name_raw=$row['doc_name_raw'];
                       $doc_name=$row['doc_name'];
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
                        <?php
                        $sql_role= "SELECT * FROM user_roles WHERE user_id='$user_id' AND (role='Read Document' OR role='Super Admin')"; 
                            $result_role=mysqli_query($db,$sql_role);
                            if (mysqli_num_rows($result_role)!=0) {
                        ?>
                         <form method="POST" target="_blank">
                        <input type="hidden" name="doc_id" value="<?php echo $id; ?>">
                        <input type="hidden" name="doc_name" value="<?php echo $doc_name; ?>">
                          <button type="submit" name="btn_read_document" class="btn btn-info"><i class="fa fa-folder-open"></i>Read</button>
                         </form>
                        <?php
                      }
                        ?>
                        </td>

                        <td>
                          <?php
                        $sql_role= "SELECT * FROM user_roles WHERE user_id='$user_id' AND (role='Comment' OR role='Super Admin')"; 
                            $result_role=mysqli_query($db,$sql_role);
                            if (mysqli_num_rows($result_role)!=0) {
                        ?>
                        <form method="POST">
                        <input type="hidden" name="doc_id" value="<?php echo $id; ?>">
                        <input type="hidden" name="doc_name" value="<?php echo $doc_name; ?>">

                          <button type="submit" name="btn_open_chat" class="btn btn-success"><i class="fa fa-comments"></i> Comment</button>
                         </form>
                         <?php
                           }
                         ?>
                       </td>

                        <td>
                          <?php
                        $sql_role= "SELECT * FROM user_roles WHERE user_id='$user_id' AND (role='Share Document' OR role='Super Admin')"; 
                            $result_role=mysqli_query($db,$sql_role);
                            if (mysqli_num_rows($result_role)!=0) {
                        ?>
                        <form method="POST">
                        <input type="hidden" name="doc_id" value="<?php echo $id; ?>">
                        <input type="hidden" name="doc_name" value="<?php echo $doc_name; ?>">

                          <button type="submit" name="btn_share_now" class="btn btn-default"><i class="fa fa-share"></i>Share</button>
                         </form>
                          <?php
                           }
                         ?>
                       </td>
                        <td>
                          <?php
                        $sql_role= "SELECT * FROM user_roles WHERE user_id='$user_id' AND (role='Delete Document' OR role='Super Admin')"; 
                            $result_role=mysqli_query($db,$sql_role);
                            if (mysqli_num_rows($result_role)!=0) {
                        ?>
                          <a href="#delete<?php echo $id;?>" data-toggle="modal"><img src="images/delete_icon.png" style="width: 30px;"></a>
                           <?php
                           }
                         ?>
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
                            <input type="hidden" name="doc_name" value="<?php echo $doc_name; ?>">
                            <p>
                                <div class="alert alert-danger">Are you Sure you want Delete <strong><?php echo $doc_name_raw; ?>?</strong></p>

                                  <label>Enter Password</label>
                                  <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
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

          <!--<input type="file" name="doc_name" id="doc_name" accept="application/pdf" /><br>-->
          <!--<input type="file" name="doc_name[]" id="doc_name" multiple accept="application/pdf" />-->

          <!--<input type="file" name="doc_name[]" id="doc_name"/>-->

          <input type="file" name="doc_name[]" id="file" multiple required>
          <br>
          <label>Select Category</label>
        
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

        
    </div><!--end of right panel-->
    
   <?php include 'config/scripts.php'; ?>

</body>
</html>
<script>  
 $(document).ready(function(){  
      $('#employee_data').DataTable();  
 });  
 </script>

  <script type="text/javascript">
  $(document).ready(function(){
    $('#department').change(function(){

      var department = $(this).val();
          $.ajax({
            url:"fetch_dep_users.php",
            method:"POST",
            data:{department:department},
            dataType:"text",
            success:function(data)
            {
              $('#users').html(data);
            }
          });
    });
  });
</script>