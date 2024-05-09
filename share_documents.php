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

if(isset($_POST['btn_share_document'])){

  $department=$_POST['department'];


 // Count total uploaded files
 $totalfiles = count($_FILES['doc_name']['name']);

 // Looping over all files
 for($i=0;$i<$totalfiles;$i++){
  
 $filename = $_FILES['doc_name']['name'][$i];

 $doc_name=md5($filename);
 
// Upload files and store in database
if(move_uploaded_file($_FILES["doc_name"]["tmp_name"][$i],'uploads/pdf/'.$doc_name)){
    
    $random_id=rand(1000,10000);

    $sql_insertdoc="INSERT INTO documents_shared (user_id,user_department_id,department_id,doc_name_raw,doc_name,date_shared,random_id) VALUES ('$user_id','$department_id','$department','$filename','$doc_name','$date_saved','$random_id')";

    mysqli_query($db,$sql_insertdoc);
   

     $sql_save_log="INSERT INTO system_logs (user_id,department_id,activity,date_logged) VALUES ('$user_id','$department_id','".$filename." Shared','$date_saved')";
            mysqli_query($db,$sql_save_log);

            
              $sql_select_u= "SELECT * FROM documents_shared WHERE random_id='$random_id'";
              $result_select_u=mysqli_query($db,$sql_select_u);

              if (mysqli_num_rows($result_select_u)!=0) {
                  
                  while ($row_select_u=mysqli_fetch_assoc($result_select_u)) {

                    $document_id=$row_select_u['id'];

                    foreach($_POST['user_id'] as $shared_user_id){
                      
  $sql_save="INSERT INTO documents_shared_id (document_id,user_id,user_dep_id,shared_user_id,department_id) VALUES ('$document_id','$user_id','$department_id','$shared_user_id','$department')";
                      //$sql_save="INSERT INTO documents_shared_id (document_id,user_id,user_dep_id,shared_user_id,department_id) VALUES ('0','0','0','0','0')";
                      mysqli_query($db,$sql_save);
                    }
                  }
            }

    //if(mysqli_query($db, $sql_insertdoc)){
      $message="Data inserted successfully";
    //}
    /*else{
      $message="Error: ".mysqli_error($db)."";
    }*/
  }else{
    $message="Error in uploading file - ".$_FILES['doc_name']['name'][$i]."";
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

    $sql="SELECT * FROM documents_shared WHERE id='$deleteid'";

    $result=mysqli_query($db,$sql);
    

    if(mysqli_num_rows($result)!=0){
        
        
        $filePath="uploads/pdf/".$doc_name;
    
        unlink($filePath);
    
    $sql_delete = "DELETE FROM documents_shared WHERE id='$deleteid'";
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
	   			<input type="submit" name="add_document" class="btn btn-info" value="Share Document" data-toggle="modal" data-target="#add_document"> 
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
                               <th>Department Shared</th>
                               <th>Document</th>
                               <th>Date Shared</th>
                               <th>Open</th>
                               <?php
                              if($admin=='1')
                              {
                                ?>
                               <th>Delete</th>
                               <?php
                             }
                               ?>
                          </tr>
                          </thead> 
                          <?php
                   $sql= "SELECT * FROM documents_shared WHERE user_department_id='$department_id' AND user_id='$user_id' ORDER BY id DESC";
              $result=mysqli_query($db,$sql);

              if (mysqli_num_rows($result)!=0) {
                  
                  while ($row=mysqli_fetch_assoc($result)) {
                      
                      $id=$row['id'];
                      $ret_department_id=$row['department_id'];
                      $doc_name_raw=$row['doc_name_raw'];
                       $doc_name=$row['doc_name'];
                      $date_shared=$row['date_shared'];

                           $sql_department= "SELECT * FROM department WHERE id='$ret_department_id'";
                      $result_department=mysqli_query($db,$sql_department);

                      if (mysqli_num_rows($result_department)!=0) {
                          
                          while ($row_department=mysqli_fetch_assoc($result_department)) {
                              
                              $department_name=$row_department['name'];
                            }
                          }
                      ?>
                  <tr>
                       <td><?php echo $department_name;?></td>
                       <td><?php echo $doc_name_raw;?></td>
                       <td><?php echo $date_shared;?></td>
                       <td>
                        <a href="#edit<?php echo $id;?>" data-toggle="modal">
                          <button class="btn btn-info"><i class="fa fa-folder-open"></i>Open</button>
                        </a>
                        </td>
                        <?php
                        if($admin=='1')
                        {
                          ?>
                        <td>
                          <a href="#delete<?php echo $id;?>" data-toggle="modal"><img src="images/delete_icon.png" style="width: 30px;"></a>
                        </td>
                        <?php
                      }
                        ?>
                      
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
          
        
        <div class="form-group">
          <label>Select Department to Share</label>
                  <?php 
                    $sqld= "SELECT * FROM department";
                    $resultd = mysqli_query($db, $sqld);
                    ?>
                    <select name="department" id="department" class="form-control" required>
                      <option></option>
                  <?php while($rowd = mysqli_fetch_array($resultd)):;?>

                  <option value="<?php echo $rowd['id'];?>"><?php echo $rowd['name'];?></option>

                  <?php endwhile;?>

                    </select>
                          <?php

                    ?>
                </div>

                <div class="users" id="users">
                  
                </div>




    </div>

    <div class="modal-footer">
      <button type="submit" name="btn_share_document" class="btn btn-primary">Share</button>
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