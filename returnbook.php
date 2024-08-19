<?php
session_start();
error_reporting();

if (!isset($_SESSION['admin'])) {
    header('location: adminlogin.php');
}

 $conn = mysqli_connect('localhost', 'root', '', 'lms');

 if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
 }
 
 if ($_SERVER["REQUEST_METHOD"] == "POST") {

     $studentid = $_POST['studentid'];
     $bookid= $_POST['bookid'];
     $fine=0;
     if($_POST['fine']!=''){
        $fine=(int)$_POST['fine'];
     }

     $sql1="SELECT * FROM issued WHERE studentid='$studentid' AND bookid='$bookid' AND returnstatus=0";
     $result1=mysqli_query($conn,$sql1);

     $sql2="SELECT activebit FROM regstudents WHERE id='$studentid'";
     $result2=mysqli_query($conn,$sql2);
     $row2=mysqli_fetch_assoc($result2);

     
     if(mysqli_num_rows($result1)==0){
        echo "<script>alert('Sorry!,student not issued this book');</script>";
     }
     elseif($row2['activebit']==0){
        echo "<script>alert('Sorry!,Your ID is INACTIVE.......');</script>";
     }
     else{
        $row=mysqli_fetch_assoc($result1);
        $returndate = date("Y-m-d");
        $issuedate=$row['issuedate'];
        $datetime1 = new DateTime($issuedate);
        $datetime2 = new DateTime($returndate);
        $interval = $datetime1->diff($datetime2);
        $daysDiff = $interval->days;
        $fee = max(0, $daysDiff - 14) * 1;

        if($fee>0){
            echo "<script>alert('Time Fee:{$fee}& Added Fee:{$fine}');</script>";
        }
        
        $confirmPayment=true;


            if($confirmPayment==true){
                $sql2 = "UPDATE issued 
                SET returndate = '$returndate',
                    returnstatus = 1,
                    fee = $fee+$fine WHERE studentid='$studentid' AND bookid='$bookid'";
                mysqli_query($conn,$sql2);

                $sql3="UPDATE books SET available=available+1 WHERE isbn=$bookid";
                mysqli_query($conn,$sql3);
                $success=true;

            }
            else{
                $success=false;
            }
            
       
        }
    
     }



 mysqli_close($conn);


?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>LMS RETURNING BOOK</title>
        <?php include 'bootstrap.php'; ?>
     
    </head>
    <body>
        <header>
            <?php include 'adminnavbar.php'; ?>
        </header>
        <main>
            <div class="text-center m-5">
                <img src="images/returnimg.jpeg" width="400px" height="200px" style="border-radius:20px">
            </div>
            <div class="formbox col-10 col-md-6 mx-auto p-3">
                    <div class='text-center'>
                    <?php
                        if (isset($success)) {
                            if ($success) {
                                echo "<h2 class='text-success'>Return successful!</h2>";
                            } else {
                                echo "<h2 class='text-danger'>Return failed!</h2>";
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
                    <div class="form-group my-3">
                        <input type="number" class="form-control" name="fine" id="fine" placeholder="Add Fine"  min=0 >
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block" >RETURN</button>
                    </div>
                </form>
            </div>
        </main>
                
    </body>
</html>