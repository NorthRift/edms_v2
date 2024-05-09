<?php
  include 'connect/server.php';

 	$department=$_POST["department"];

 $sql_dep_user="SELECT * FROM users WHERE department_id='$department'";
 $result_dep_user=mysqli_query($db,$sql_dep_user);


    while($row_dep_user = mysqli_fetch_array($result_dep_user)){

    	$user_id=$row_dep_user["id"];
    	$name=$row_dep_user["name"];

    	?>

    	<input type="checkbox" id="user_id" name="user_id[]" value="<?php echo $user_id;?>">&nbsp;&nbsp;<?php echo $name;?><br>

    	<?php

    }
?>