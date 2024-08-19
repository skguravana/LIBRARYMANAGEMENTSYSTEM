<?php
    session_start();
    error_reporting(0);

    if(!isset($_SESSION['user_id'])){
        header('location:userlogin.php');
    }

    $conn = mysqli_connect("localhost","root","","lms");

    if(!$conn){
        die("connection failed".mysqli_error($conn));

    }
	$query = "SELECT * FROM regstudents WHERE id='" . $_SESSION['user_id'] . "'";
	$result = mysqli_query($conn,$query);
	$row = mysqli_fetch_assoc($result);
	
	
	
?>

<!DOCTYPE html>
<html lang="en">
    <head>    
    	<title>LMS USER PROFILE</title>
        <?php include 'bootstrap.php'; ?>
    </head>
    <body>
        <header>
            <?php include 'usernavbar.php';?>
        </header> 
        <main>
    	    <div class="card-header bg-success mt-3">
                <h1 class="text-center ">Profile</h1>
            </div> 


            <div class="col-md-7 col-sm-10 mx-auto fs-2 border border-dark border-3 p-2 m-5" >
    	    	<table class='mx-auto'>
    	    		<tbody >
    	    			<tr>
    	    				<td style='font-weight:bold'>ID</td>
    	    				<td>: &emsp;<?php echo $row['id']?></td>
    	    			</tr>
    	    			<tr>
    	    				<td style='font-weight:bold'>NAME</td>
    	    				<td>: &emsp;<?php echo $row['name']?> </td>
    	    			</tr>
    	    			<tr>
    	    				<td style='font-weight:bold'>E-MAIL</td>
    	    				<td>: &emsp;<?php echo $row['email'] ?> </td>
    	    			</tr>
    	    			<tr>
    	    				<td style='font-weight:bold'>MOBILE</td>
    	    				<td>: &emsp;<?php echo $row['phno']?></td>
    	    			</tr>
                        <tr>
    	    				<td style='font-weight:bold'>REGISTER DATE </td>
    	    				<td> : &emsp;<?php echo substr($row['registerdate'],0,11)?></td>
    	    			</tr>
                        <tr>
    	    				<td style='font-weight:bold'>STATUS</td>
    	    				<td>: &emsp;<?php if($row['activebit']==1){echo "ACTIVE";}else{echo "INACTIVE";} ?></td>
    	    			</tr>
    	    		</tbody>
    	    	</table>
                <div class="d-flex flex-row justify-content-between m-4">
                    <a class="btn btn-primary" href="logout.php" target="_blank">Logut</a>
                    <a class="btn btn-primary" href="userchangepassword.php" target="_parent">change password</a>
                </div>

            </div>
        </main>


    </body>
</html>