 <?php
//  session_start();
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
 $sql= "SELECT * FROM users WHERE id='$user_id'";
              $result=mysqli_query($db,$sql);

              if (mysqli_num_rows($result)!=0) {
                  
                  while ($row=mysqli_fetch_assoc($result)) {
                      
                    $user_name=$row['name'];
               }
             }
             ?>
<!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-9">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    <div class="header-left">
                        
                    </div>

                    <div class="row">
                        
                         <?php
                        $sql_role= "SELECT * FROM user_roles WHERE user_id='$user_id' AND (role='Share Document' OR role='Super Admin')"; 
                            $result_role=mysqli_query($db,$sql_role);
                            if (mysqli_num_rows($result_role)!=0) {
                        ?>
                        <a class="nav-link" href="share_documents.php">
                          <i class="fa fa-share"></i>
                          <span class="menu-title">Share Documents</span>
                          <i class="menu-arrow"></i>
                        </a> 
                         <?php
                           }
                         ?>
                     <?php
                        $sql_role= "SELECT * FROM user_roles WHERE user_id='$user_id' AND (role='View Shared Document' OR role='Super Admin')"; 
                            $result_role=mysqli_query($db,$sql_role);
                            if (mysqli_num_rows($result_role)!=0) {
                        ?>
                       <a class="nav-link" href="received_documents.php">
                          <i class="fa fa-share-square-o"></i>
                          <span class="menu-title">Documents Received</span>
                          <i class="menu-arrow"></i>
                        </a> 
                         <?php
                           }
                         ?>

                          <?php
                        $sql_role= "SELECT * FROM user_roles WHERE user_id='$user_id' AND (role='View Contact List' OR role='Super Admin')"; 
                            $result_role=mysqli_query($db,$sql_role);
                            if (mysqli_num_rows($result_role)!=0) {
                        ?>
                        <a class="nav-link" href="contact_list.php">
                          <i class="fa fa-address-book"></i>
                          <span class="menu-title">Contact List</span>
                          <i class="menu-arrow"></i>
                        </a>
                         <?php
                           }
                         ?>

                         <?php
                        $sql_role= "SELECT * FROM user_roles WHERE user_id='$user_id' AND (role='View System Logs' OR role='Super Admin')"; 
                            $result_role=mysqli_query($db,$sql_role);
                            if (mysqli_num_rows($result_role)!=0) {
                        ?>
                        <a class="nav-link" href="system_logs.php">
                          <i class="fa fa-file"></i>
                          <span class="menu-title">System Logs</span>
                          <i class="menu-arrow"></i>
                        </a>
                         <?php
                           }
                         ?>

                         <?php
                        $sql_role= "SELECT * FROM user_roles WHERE user_id='$user_id' AND role='Super Admin'"; 
                            $result_role=mysqli_query($db,$sql_role);
                            if (mysqli_num_rows($result_role)!=0) {
                        ?>
                        <a class="nav-link" href="other_departments.php">
                          <i class="fa fa-address-book"></i>
                          <span class="menu-title">Other Departments</span>
                          <i class="menu-arrow"></i>
                        </a>
                         <?php
                           }
                         ?>

                    </div>
                      
                    

                </div>

                <div class="col-sm-3">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            <img class="rounded-circle" src="images/admin.png" style="width: 30px;">

                            <label><?php echo $user_name; ?></label>

                        </a>

                        <div class="user-menu dropdown-menu">

                                <a class="dropdown-item" href="profile.php"><i class="fa fa-user"></i>My Profile </a>
                                <div class="dropdown-divider"></div>

                                <?php
              $sql_role= "SELECT * FROM user_roles WHERE user_id='$user_id' AND (role='Admin' OR role='Super Admin')"; 
                            $result_role=mysqli_query($db,$sql_role);
                            if (mysqli_num_rows($result_role)!=0) {
                        ?>

                                <a class="dropdown-item" href="add_department.php"><i class="fa fa-cog"></i>Settings </a>

                                <div class="dropdown-divider"></div>

                                 <?php
                           }
                         ?>

                                <a class="dropdown-item" href="logout.php"><i class="fa fa-power-off"></i>Logout </a>
                        </div>
                    </div>

                    

                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->
        