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

    if(isset($_SESSION["doc_id"])){
     $_SESSION['doc_id'];
     $doc_id=$_SESSION['doc_id'];
    }

    if(isset($_SESSION["doc_name"])){
     $_SESSION['doc_name'];
     $doc_name=$_SESSION['doc_name'];
    }


   

  date_default_timezone_set('Africa/Nairobi');
$date_saved = date('d/m/Y h:i:s a', time());

    global $message;

if(isset($_POST['btn_share_now'])){

$document_id=$_POST['document_id'];
$department=$_POST['department'];


$sql_documents= "SELECT * FROM documents WHERE id='$document_id'";
              $result_documents=mysqli_query($db,$sql_documents);

              if (mysqli_num_rows($result_documents)!=0) {
                  
                  while ($row_documents=mysqli_fetch_assoc($result_documents)) {
                      
                      $id=$row_documents['id'];
                      $doc_un_id=$row_documents['doc_un_id'];
                      $doc_name_raw=$row_documents['doc_name_raw'];
                       $doc_name=$row_documents['doc_name'];
                      $category_id=$row_documents['category_id'];
                      $dep_id=$row_documents['department_id'];

                      $random_id=rand(1000,10000);

$sql_insertdoc="INSERT INTO documents_shared (user_id,user_department_id,department_id,doc_name_raw,doc_name,date_shared,random_id) VALUES ('$user_id','$department_id','$department','$doc_name_raw','$doc_name','$date_saved','$random_id')";

    mysqli_query($db,$sql_insertdoc);

     $sql_save_log="INSERT INTO system_logs (user_id,department_id,activity,date_logged) VALUES ('$user_id','$department_id','".$doc_name_raw." Shared','$date_saved')";
            mysqli_query($db,$sql_save_log);

            
              $sql_select_u= "SELECT * FROM documents_shared WHERE random_id='$random_id'";
              $result_select_u=mysqli_query($db,$sql_select_u);

              if (mysqli_num_rows($result_select_u)!=0) {
                  
                  while ($row_select_u=mysqli_fetch_assoc($result_select_u)) {

                    $document_id=$row_select_u['id'];

                    foreach($_POST['user_id'] as $shared_user_id){
                      
  $sql_save="INSERT INTO documents_shared_id (document_id,user_id,user_dep_id,shared_user_id,department_id) VALUES ('$document_id','$user_id','$department_id','$shared_user_id','$department')";
                      mysqli_query($db,$sql_save);
                    }
                  }
            }

            $message="Document Shared";

          }
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

            <div class="col-md-8">

              <iframe src="uploads/pdf/<?php echo $doc_name;?>" width="100%" height="450px">
                          
              </iframe>
              
            </div>
            <div class="col-md-4">

              <br>

              <label style="color: blue;"><?php echo $message; ?></label>


              <form method="POST">
                <input type="hidden" name="document_id" class="form-control" value="<?php echo $doc_id; ?>">

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
                <br>

                <input type="submit" name="btn_share_now" class="btn btn-warning" value="Share Now">
              </form>

              
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