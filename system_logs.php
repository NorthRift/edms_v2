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
  
 $filename = $_FILES['doc_name']['name'][$i];

 $doc_un_id=uniqid();
 
// Upload files and store in database
if(move_uploaded_file($_FILES["doc_name"]["tmp_name"][$i],'uploads/pdf/'.$filename)){
    
    $sql="INSERT INTO documents (doc_un_id,doc_name,user_id,category_id,department_id,date_saved,status) VALUES ('$doc_un_id','$filename','$user_id','$category_id','$department_id','$date_saved','$status')";

    if(mysqli_query($db, $sql)){
      $message="Data inserted successfully";
    }
    else{
      $message="Error: ".mysqli_error($db)."";
    }
  }else{
    $message="Error in uploading file - ".$_FILES['doc_name']['name'][$i]."";
  }
 
 }
}

if(isset($_POST['delete_acc'])){
    $deleteid = $_POST['deleteid'];
    $doc_name = $_POST['doc_name'];


    $sql="SELECT * FROM documents WHERE id='$deleteid'";

    $result=mysqli_query($db,$sql);
    

    if(mysqli_num_rows($result)!=0){
        
        
        $filePath="uploads/pdf/".$doc_name;
    
        unlink($filePath);
    
    $sql_delete = "DELETE FROM documents WHERE id='$deleteid'";
    mysqli_query($db,$sql_delete);
    $message="Deleted";
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
        
      </div>
       

      <div class="row" style="overflow-y: scroll; height:410px; margin-top: 0px;">
             <div class="table-responsive" >  
                     <table id="employee_data" class="table table-striped table-bordered">  
                          <thead>  
                          <tr>  
                               <th>User Name</th>
                               <th>Department</th>
                               <th>Activity</th>
                               <th>Date</th>
                          </tr>
                          </thead> 
                          <?php
                   
                          if($department_id=='3'){
                     $sql= "SELECT * FROM system_logs ORDER BY id DESC";
                   }else{
                    $sql= "SELECT * FROM system_logs WHERE department_id='$department_id' ORDER BY id DESC";
                   }
              $result=mysqli_query($db,$sql);

              if (mysqli_num_rows($result)!=0) {
                  
                  while ($row=mysqli_fetch_assoc($result)) {
                      
                       $id=$row['id'];
                       $ret_user_id=$row['user_id'];
                       $ret_department_id=$row['department_id'];
                       
                       $activity=$row['activity'];
                       $date_logged=$row['date_logged'];

                       $sql_department= "SELECT * FROM users WHERE id='$ret_user_id'";
                      $result_department=mysqli_query($db,$sql_department);

                      if (mysqli_num_rows($result_department)!=0) {
                          
                          while ($row_department=mysqli_fetch_assoc($result_department)) {
                              
                              $user_name=$row_department['name'];
                            }
                          }

                       $sql_department= "SELECT * FROM department WHERE id='$ret_department_id'";
                      $result_department=mysqli_query($db,$sql_department);

                      if (mysqli_num_rows($result_department)!=0) {
                          
                          while ($row_department=mysqli_fetch_assoc($result_department)) {
                              
                              $department_name=$row_department['name'];
                            }
                          }
                      ?>
                  <tr>
                     <td><?php echo $user_name;?></td>
                     <td><?php echo $department_name;?></td>
                     <td><?php echo $activity;?></td>
                     <td><?php echo $date_logged;?></td>
                      
                     </tr> 

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
<script>  
 $(document).ready(function(){  
      $('#employee_data').DataTable();  
 });  
 </script>