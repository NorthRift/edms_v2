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

?>
<style type="text/css">
  .container_data {
  clear: both;
  position: relative;
}

.container_data .arrow {
  width: 12px;
  height: 20px;
  overflow: hidden;
  position: relative;
  float: left;
  top: 6px;
  right: -1px;
}

.container_data .arrow .outer {
  width: 0;
  height: 0;
  border-right: 20px solid #000000;
  border-top: 10px solid transparent;
  border-bottom: 10px solid transparent;
  position: absolute;
  top: 0;
  left: 0;
}

.container_data .arrow .inner {
  width: 0;
  height: 0;
  border-right: 20px solid #dce4ec;
  border-top: 10px solid transparent;
  border-bottom: 10px solid transparent;
  position: absolute;
  top: 0;
  left: 2px;

}

.container_data .message-body {
  float: left;
  width: 200px;
  height: auto;
  border: 1px solid #000000;
  padding: 6px 8px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  -o-border-radius: 5px;
  border-radius: 5px;
  background-color: #dce4ec;
}

.container_data .message-body p {
  margin: 0;
}
</style>

<?php
$sql= "SELECT * FROM document_comments WHERE department_id='$department_id' AND doc_id='$doc_id'";
$result=mysqli_query($db,$sql);

if (mysqli_num_rows($result)!=0) {
  
  while ($row=mysqli_fetch_assoc($result)) {
      $doc_id=$row['doc_id'];
      $user_id_comment=$row['user_id'];
      $comment=$row['comment'];
      $date_saved=$row['date_saved'];


      $sql_users= "SELECT * FROM users WHERE id='$user_id_comment'";
$result_users=mysqli_query($db,$sql_users);

if (mysqli_num_rows($result_users)!=0) {
  
  while ($row_users=mysqli_fetch_assoc($result_users)) {
      $get_user_name=$row_users['name'];



      if($user_id_comment==$user_id){

        ?>
      <div class="row">

        <div class="col-md-6">  
        </div>

     <div class="col-md-6"> 
   <div class="container_data">
  <div class="arrow">
    <div class="outer"></div>
    <div class="inner"></div>
  </div>
  <div class="message-body">
    <label style="font-weight: 900; color: #08B6CE;"><?php echo $get_user_name; ?></label><br>
    <?php echo $comment; ?><br>
    <label style="font-size: 12px; font-weight: 900; color: #d23b05;"><?php echo $date_saved; ?></label>
  </div>
  <br>
</div>

</div>
</div>
<br>

<?php
        
      }else if($user_id_comment!=$user_id){

        ?>
<div class="row">
  <div class="col-md-6">
  <div class="container_data">
  <div class="message-body">
    <label style="font-weight: 900; color: #08B6CE;"><?php echo $get_user_name; ?></label><br>
    <?php echo $comment; ?><br>
    <label style="font-size: 12px; font-weight: 900; color: #d23b05;"><?php echo $date_saved; ?></label>
  </div>
</div>
</div>

</div>
<br>


<?php

}
}
      }

      
  }
}
?>