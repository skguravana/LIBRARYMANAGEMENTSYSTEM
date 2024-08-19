<?php
    session_start(0);
    error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>LMS PASSWORD</title>
        <?php include 'bootstrap.php'; ?>
    </head>
    <body>
        <header>
            <?php include 'adminnavbar.php';?>
        </header> 
    	<main>
            <div class="container col-md-4 mt-5">
                <div class="card card-xs">
                    <div class="card-header bg-success">
                        <h2 class="text-center">CHANGE_PASSWORD</h2>
                    </div>
                    <div class="card-body">
    				<div>
    					        <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
                    $admin_email = $_POST['admin_email'];
                    $oldpassword = $_POST['oldpassword'];
    				$newpassword = $_POST['newpassword'];
                
                
                    $conn = mysqli_connect('localhost','root','','lms');
                
                
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                
                
    				if($oldpassword==$newpassword){
    					echo "<h3 style='color:red'>Try New passwords</h3>";
    				}
                    else{
                        $query0 = "SELECT * FROM admins WHERE email='$admin_email' AND password='$oldpassword'";
                        $result = mysqli_query($conn, $query0);
                        
                        if (mysqli_num_rows($result) == 0) {
                            echo "<h3 style='color:RED'>Invalid Email/Password.</h3>";
                        }
                        else {
                            $query1 = "UPDATE admins SET password='$newpassword' WHERE email='$admin_email'  ";
                                      
                            mysqli_query($conn, $query1);
                            echo "<h3 style='color:green'>PASSWORD_CHANGED</h3>";
                        
                        }
                    }
                
                    mysqli_close($conn);
                } 
            ?>
    				</div>
                        <form method="post" >
                            <div class="mb-3">
    						<input type="text" id="admin_email" name="admin_email" class="form-control" placeholder="E-Mail" required > 
    					</div>
    					<div class="mb-3"> 
                            <input type="password" id="oldpassword" name="oldpassword" class="form-control" placeholder="Old Password" required>
    					</div>
    					<div class="mb-3"> 
                            <input type="password" id="newpassword" name="newpassword" class="form-control" placeholder="New password" required>
    					</div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block ">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
            
    </body>
</html>