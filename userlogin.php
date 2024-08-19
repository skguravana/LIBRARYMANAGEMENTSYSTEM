<?php
    session_start();
    error_reporting();

    $conn=mysqli_connect('localhost','root','','lms');

    if(!$conn){
        die ("Connection failes:".mysqli_connect_error());
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $email=$_POST['email'];
        $password=$_POST['password'];

        $sql="SELECT * FROM regstudents WHERE email=? and password=?";
        $stmt = mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt,'ss',$email,$password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if(mysqli_num_rows($result)){
            $row=mysqli_fetch_assoc($result);
            $_SESSION['user_id']=$row['id'];
            $success=true;
            header('location:userhome.php');
        }
        else{
            $success=false;
        }
    }


?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>LMS USER LOGIN</title>
        <?php include 'bootstrap.php'; ?>
    </head>
    <body>
        <header>
            <?php include 'indexnavbar.php';?>
        </header>
        <main>
            <div class="text-center">
                    <img src="images/loginimg.png" width="200px">
                </div>
            <div class="formbox col-10 col-md-5 mx-auto p-3 m-5">
                    <div class='text-center'>
                        <?php
                        if (isset($success)) {
                            if ($success) {
                                echo "<h2 class='text-success'>Login successful!</h2>";
                            } else {
                                echo "<h2 class='text-danger'>Login failed!</h2>";
                            }
                        }
                        ?>
                    </div>
                <div class="text-center rounded-pill bg-info">
                    <h1>User Login</h1>
                </div>
                <form method='post'>
                    
                    <div class="form-group my-4">
                        <input type="email" class="form-control p-2" name="email" id="email" placeholder="E-mail" required>
                    </div>
                    <div class="form-group my-4">
                        <input type="password" class="form-control p-2" name="password" id="password" placeholder="Password" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block" >Log In</button>
                    </div>
                    <p class="mt-3 text-center">new user <a href="userregister.php">register</a></p>
                </form>
            </div>
        </main>
                
    </body>
</html>