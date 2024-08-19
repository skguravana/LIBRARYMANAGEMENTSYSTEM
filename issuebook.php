<?php
$success = null;
session_start();
error_reporting(0);

if (!isset($_SESSION['admin'])) {
    header('location: adminlogin.php');
}

$conn = mysqli_connect('localhost', 'root', '', 'lms');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && !empty($_POST['studentid'])) {
    $studentid = $_POST['studentid'];
    $bookid= $_POST['bookid'];

    $sql1="SELECT * FROM books WHERE isbn='$bookid'";
    $result1=mysqli_query($conn,$sql1);
    $row1=mysqli_fetch_assoc($result1);

    $sql2="SELECT * FROM regstudents WHERE id='$studentid'";
    $result2=mysqli_query($conn,$sql2);
    $row2=mysqli_fetch_assoc($result2);

    $sql3="SELECT * FROM issued WHERE studentid='$studentid' AND bookid='$bookid' AND returnstatus=0";
    $result3=mysqli_query($conn,$sql3);

    if(mysqli_num_rows($result1)<1){
        echo "<script>alert('Sorry!,WRONG ISBN');</script>";
        $success=false;
    }
    elseif(mysqli_num_rows($result2)<1){
        echo "<script>alert('Sorry!,WRONG Student ID');</script>";
        $success=false;
    }
    elseif($row2['activebit']==0){
        echo "<script>alert('Sorry!,Your ID is INACTIVE.......');</script>";
        $success=false;
    }
    elseif(mysqli_num_rows($result3)>0){
        echo "<script>alert('Sorry!,you already issued this book');</script>";
        $success=false;
    }
    else{
        if($row1['available']==0){
            echo "<script>alert('Sorry!,Book out of Stock');</script>";
            $success=false;
        }
        else{
            $sql4="UPDATE books SET available=available-1 WHERE isbn='$bookid'";
            mysqli_query($conn,$sql4);

            $sys_date = date("Y-m-d");
            $sql4 = "INSERT INTO issued (studentid, bookid, issuedate, returnstatus,fee) VALUES (?, ?, ?, 0,0)";
            $stmt = mysqli_prepare($conn, $sql4);
            mysqli_stmt_bind_param($stmt, "sss", $studentid, $bookid, $sys_date);
            mysqli_stmt_execute($stmt);
            $success=true;
        }
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>LMS ISSUING BOOK</title>
        <?php include 'bootstrap.php'; ?>

    </head>
    <body>

        <header>
            <?php include 'adminnavbar.php'; ?>
        </header>

        <main>
            <div class="text-center m-5">
                <img src="images/issueimg.jpeg" width="400px" height="200px" style="border-radius:20px">
            </div>
            <div class="formbox col-10 col-md-6 mx-auto p-3">
                    <div class='text-center'>
                    <?php
                        if ($success !== null) {
                            if ($success) {
                                echo "<h2 class='text-success'>Issue successful!</h2>";
                            } else {
                                echo "<h2 class='text-danger'>Issue failed!</h2>";
                            }
                        }
                        ?>
                        
                    </div>
                <form method='post'>
                    <div class="form-group my-3">
                        <input type="text" class="form-control" name="studentid" id="studentid" placeholder="Student-ID" maxlength="10" required>
                    </div>
                    <div class="form-group my-3">
                        <input type="text" class="form-control" name="bookid" id="bookid" placeholder="Book-ID"  maxlength="10" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-primary btn-block" >ISSUE</button>
                    </div>
                </form>
            </div>
                    
        </main>
                
    </body>
    </html>
