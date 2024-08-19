<?php
    session_start();
    error_reporting(0);

    $conn=mysqli_connect('localhost','root','','lms');

    if(!$conn){
        die ("Connection failes:".mysqli_connect_error());
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $email=$_POST['email'];
        $password=$_POST['password'];

        $sql = "SELECT * FROM admins WHERE email = ? AND password = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if(mysqli_num_rows($result)){
            $row=mysqli_fetch_assoc($result);
            $success=true;
            $_SESSION['admin']=$row['adminid'];
            header('location:adminhome.php');
        }
        else{
            $success=false;
        }
    }


?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>LMS ADMIN LOGIN</title>
        <?php include 'bootstrap.php'; ?>
    
    </head>
    <body>
        <header>
            <?php include 'indexnavbar.php';?>
        </header>
    
        <main>
            <div class="text-center my-5">
                <img src="images/loginimg.png" width="200px">
            </div>
            <div class="formbox col-11 col-md-5 mx-auto p-3 mt-5">
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
                    <h1>Admin Login</h1>
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
                </form>
            </div>
        </main>
                    
    </body>
</html>