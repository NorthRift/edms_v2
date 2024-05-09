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

if(isset($_POST['btn_comment'])){
    //$doc_id = $_POST['doc_id'];
    $comment = $_POST['comment'];

    $sql="INSERT INTO document_comments (doc_id,department_id,user_id,comment,date_saved) VALUES ('$doc_id','$department_id','$user_id','$comment','$date_saved')";
    mysqli_query($db,$sql);

    $message="Saved";

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


    <!--<aside id="left-panel" class="left-panel">
        <?php //include 'config/side_bar.php'; ?>
    </aside>-->

	   	 
        <div class="row">
          
          <div class="col-md-1">
          </div>
            <div class="col-md-10">

              <iframe src="uploads/pdf/<?php echo $doc_name;?>" width="100%" style="height: 100vh;">
                          
              </iframe>
              
            </div>
            
            <div class="col-md-1">
          </div>
           
          </div>

    <?php
    //include 'footer.php';
    ?>  
    
   <?php include 'config/scripts.php'; ?>

</body>
</html>