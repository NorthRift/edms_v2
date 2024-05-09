<?php 
// session_start();
    include 'connect/server.php';

    if(isset($_SESSION["department_id"])){
     $_SESSION['department_id'];
     $department_id=$_SESSION['department_id'];
    }

    if(isset($_POST['btn_open_doc_category'])){
        
        $category_id=$_POST['category_id'];

        $_SESSION['category_id']=$category_id;

        header("location: doc_category.php");
    }
 ?>
<nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>

                <a class="navbar-brand" href="#"><img src="images/coat_of_arms_kenya.png" alt="Logo" style="width: 70px;">
                    <label>EDMS</label>
                </a>
               
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
               <ul class="nav navbar-nav">
                   
                    <li class="menu-item-has-children dropdown">
                        <a href="dashboard.php"  aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop" style="color: #1184e8;
    text-shadow: 1px 1px 1px #1184e8;"></i>Dashboard</a>
                    </li>
            
                <?php

          $sql= "SELECT * FROM category WHERE department_id='$department_id' ORDER BY id ASC";
            $result=mysqli_query($db,$sql);

            if (mysqli_num_rows($result)!=0) {
                
                while ($row=mysqli_fetch_assoc($result)) {
                    
                    $id=$row['id'];
                    $name=$row['name'];
                    ?>
                    <li class="menu-item-has-children dropdown">
                        <a href="doc_category.php?category_id=<?php echo $id;?>"  aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-clone" style="color: #1184e8;
    text-shadow: 1px 1px 1px #1184e8;"></i><?php echo $name; ?></a>
                    </li>
                    <?php
                }
            }
          $sql_role= "SELECT * FROM user_roles WHERE user_id='$user_id' AND (role='Admin' OR role='Super Admin')"; 
                            $result_role=mysqli_query($db,$sql_role);
                            if (mysqli_num_rows($result_role)!=0) {

            $sql_all= "SELECT count(1) FROM documents WHERE department_id='$department_id' AND status=0";
          $result_all=mysqli_query($db,$sql_all);

          while($row_all= mysqli_fetch_array($result_all)){

                  $count_all=$row_all[0];
            
            ?>
          <li class="menu-item-has-children dropdown">
                        <a href="pending_documents.php"  aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-clone" style="color: #1184e8;
    text-shadow: 1px 1px 1px #1184e8;"></i>Pending Documents (<?php echo $count_all; ?>)</a>
                    </li>
            <?php
          }
          }
          ?>

          <li class="menu-item-has-children">
            
            <a href="events_calendar.php"> <i class="menu-icon fa fa-calendar"></i>Calendar</a>
        </li>

        <li class="menu-item-has-children">
            
            <a href="logout.php"> <i class="menu-icon fa fa-sign-out"></i>Logout</a>
        </li>
                   
                    
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>