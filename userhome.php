<?php
session_start();
error_reporting(0);

if (!isset($_SESSION['user_id'])) {
    header('location: userlogin.php');
}

$conn = mysqli_connect('localhost', 'root', '', 'lms');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql1="SELECT COUNT(*) AS noofbooksissued,SUM(fee) AS totalfine FROM issued WHERE studentid='{$_SESSION['user_id']}'";
$result1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_assoc($result1);
$noofbooksissued=$row1['noofbooksissued'];
$totalfee=$row1['totalfine'];

$sql2="SELECT * FROM issued WHERE studentid='{$_SESSION['user_id']}' AND returnstatus=0";
$result2=mysqli_query($conn,$sql2);
$noofbookstoreturn=mysqli_num_rows($result2);




mysqli_close($conn);
?>







<!DOCTYPE html>
<html lang="en">
    <head>
        <title>LMS USER HOME</title>
        <?php include 'bootstrap.php'; ?>
    </head>
    <body>
        <header>
            <?php include 'usernavbar.php';?>
        </header> 
        <main>
            <div class="imagesholder d-flex flex-column flex-md-row mt-5 col-12">
                
                <div class="listitem col-sm-6 mx-auto text-center col-md-2">
                    <img src="images/booksimg.png" width="200px">
                    <p> BOOKS ISSUED:<?php echo" $noofbooksissued"?></p>
                </div>
                <div class="listitem col-sm-6 mx-auto text-center col-md-2">
                    <img src="images/areturnbooksimg.jpg" width="200px" height="200px" style="border-radius: 100px;">
                    <P>BOOKS TO BE RETURNED :<?php echo " $noofbookstoreturn"?></P>
                </div>
                <div class="listitem col-sm-6 mx-auto text-center col-md-2">
                    <img src="images/feeimg.png" width="200px" style="border-radius: 100px;">
                    <P>TOTAL FINES :<?php echo " $totalfee"?></P>
                </div>
            </div>
            
        </main>
    </body>
</html>