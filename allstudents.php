<?php
session_start();
error_reporting(0);

if (!isset($_SESSION['admin'])) {
    header('location: adminlogin.php');
}

$conn = mysqli_connect('localhost', 'root', '', 'lms');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $studentid = $_POST['studentid'];
    $sql = "SELECT * FROM regstudents WHERE id='$studentid' ORDER BY id";
    $result = mysqli_query($conn, $sql);
} else {
    $sql = "SELECT * FROM regstudents  ORDER BY id";
    $result = mysqli_query($conn, $sql);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inactive'])) {

    $inactive = $_POST['inactive']; 
    $sql="SELECT activebit FROM regstudents WHERE id='$inactive'";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);

    if($row['activebit']==1){
        echo "<script>alert('Are You Sure To INACTIVE..{$inactive}');</script>";
        $sql = "UPDATE regstudents SET activebit=0 WHERE id='$inactive'";
    }
    else{
        echo "<script>alert('Are You Sure To ACTIVE..{$inactive}');</script>";
        $sql = "UPDATE regstudents SET activebit=1 WHERE id='$inactive'";
    }
    mysqli_query($conn,$sql);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
    
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>LMS Registered Students</title>
        <?php include 'bootstrap.php'; ?>
        <style>
            .tablebox{
                border:2px solid black;
                overflow: scroll;
                height:250px;
            }
            .table tr th {
                background-color: #ccc; 
                border-bottom:2px solid black;
            }

        </style>
    </head>
    <body>
        
        <header>
            <?php include 'adminnavbar.php'; ?>
        </header>

        <main>

            <!div class="text-center">
                <!img src="images/libraryimg.webp" width="350px" >
            <!/div>

            <div class="container m-3">
                <form class="row g-3" method="post">
                    <div class="col-auto">
                        <label class="visually-hidden" for="studentid">Search by ID</label>
                        <input type="text" class="form-control" id="studentid" name="studentid" placeholder="Search by ID" required>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" name="search">Search</button>
                    </div>
                </form>
            </div>
            <div class="container m-3">
                <form class="row g-3" method="post">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" name="all">ALL</button>
                    </div>
                </form>
            </div>

            <div class="text-center ">
                <?php
                    $no_of_students=mysqli_num_rows($result);
                    echo "<h5 clas='fw-bold'>NO OF USERS : {$no_of_students}</h5>";
                ?>
            </div>

            <div class="tablebox col-10 mx-auto">

                <table class="table">
                    <tr>
                        <th>S.No</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Phno</th>
                        <th>Password</th>
                        <th>Register Date</th>
                        <th>Update</th>
                    </tr>
                    <?php

                    if ($no_of_students> 0) {
                        $count = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $count++ . "</td>";
                            echo "<td>" . $row['id'] . "</td>"; 
                            echo "<td>" . $row['name'] . "</td>"; 
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['phno'] . "</td>";
                            echo "<td>" . $row['password'] . "</td>";
                            echo "<td>" . $row['registerdate'] . "</td>";
                            if ($row['activebit'] == 1) {
                                echo "<td> <form method='post'><button type='submit' name='inactive' value='{$row['id']}' class='bg-success text-white'>Active</button></form> </td>"; 
                            } else {
                                echo "<td> <form method='post'><button type='submit' name='inactive' value='{$row['id']}' class='bg-danger text-white'>Inactive</button></form> </td>"; 

                            }

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No books in the library.</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </main>
                         
    </body>
</html>
