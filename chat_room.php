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

     <script type="text/javascript">
    function ajax(){
    var req=new XMLHttpRequest();
    req.onreadystatechange=function(){
    if(req.readyState==4 && req.status==200){
    document.getElementById('chat').innerHTML=req.responseText;

  }

  }
  req.open('GET','load_chat.php',true);
  req.send();


  }
  setInterval(function(){ajax()},1000);

  </script>

</head>
<body>


    <aside id="left-panel" class="left-panel">
        <?php include 'config/side_bar.php'; ?>
    </aside>


    <div id="right-panel" class="right-panel">

        <?php include 'config/right_panel.php'; ?>


       <div class="content">
	   	 
        <div class="row">

            <div class="col-md-6">

              <iframe src="uploads/pdf/<?php echo $doc_name;?>" width="100%" height="450px">
                          
              </iframe>
              
            </div>
            <div class="col-md-6">

              

              <form method="POST">

              <div style="overflow-y: scroll; height:300px; margin-top: 0px;">

                  <div id="chat_box">
                <div id="chat">

                </div>
              </div>

              </div>

              <div class="row" style="margin-left: 30px; margin-right: 30px;">

                  <label>Type Comment...</label>

                  <textarea name="comment" class="form-control" style="background-color: #DCDCDC;">
                    
                  </textarea><br>
                  <input type="submit" name="btn_comment" class="btn btn-info" value="Send">
                  
                
              </div>

              <!--<input type="text" name="comment" class="form-control" placeholder="Write Comment" style="background-color: #DCDCDC; height: 70px;" required><br>-->
                

              </form>

              <label style="color: blue;"><?php echo $message; ?></label>
              
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