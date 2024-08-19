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

$sql1="SELECT * FROM regstudents";
$result1=mysqli_query($conn,$sql1);
$noofusers=mysqli_num_rows($result1);

$sql2="SELECT SUM(available) AS totalbooks FROM books";
$result2=mysqli_query($conn,$sql2);
$row=mysqli_fetch_assoc($result2);
$noofbooks=$row['totalbooks'];

$sql3="SELECT SUM(fee) AS totalfee FROM issued";
$result3=mysqli_query($conn,$sql3);
$row=mysqli_fetch_assoc($result3);
$totalfee=$row['totalfee'];

$sql4="SELECT * FROM issued WHERE returnstatus=0";
$result4=mysqli_query($conn,$sql4);
$noofbookstoreturn=mysqli_num_rows($result4);


mysqli_close($conn);
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS ADMIN HOME</title>
    <?php include 'bootstrap.php'; ?>

</head>
<body>
    <header>
        <?php include 'adminnavbar.php'; ?>
    </header>
    <main>
        <div class="imagesholder d-flex flex-column  flex-xl-row mt-5 col-12">
            <div class="listitem col-10 mx-auto px-auto pt-2  text-center col-xl-2">
                <img src="images/regusersimg (1).png" width="200px">
                <p>NO OF USERS :<?php echo" $noofusers"?></p>
            </div>
            <div class="listitem col-10 mx-auto px-auto pt-2 text-center col-xl-2">
                <img src="images/booksimg.png" width="200px">
                <p>TOTAL BOOKS :<?php echo" $noofbooks"?></p>

            </div>
            <div class="listitem col-10 mx-auto px-auto pt-2 text-center col-xl-2">
                <img src="images/feeimg.png" width="200px" style="border-radius: 100px;">
                <P>TOTAL FINES :<?php echo" $totalfee"?></P>
            </div>
            <div class="listitem col-10 mx-auto px-auto pt-2 text-center col-xl-2">
                <img src="images/areturnbooksimg.jpg" width="200px" height="200px" style="border-radius: 100px;">
                <P>BOOKS TO BE RETURNED :<?php echo " $noofbookstoreturn"?></P>
            </div>
            
        </div>
    </main>
</body>
</html>