<?php
    session_start();
    error_reporting(0);

    if(!isset($_SESSION['admin'])){
        header('location:adminlogin.php');
    }

    $conn = mysqli_connect("localhost","root","","lms");

    if(!$conn){
        die("connection failed".mysqli_error($conn));

    }
	$query = "SELECT * FROM admins WHERE adminid='" . $_SESSION['admin'] . "'";
	$result = mysqli_query($conn,$query);
	$row = mysqli_fetch_assoc($result);
	
	
	
?>

<!DOCTYPE html>
<html lang="en">
    <head>    
    	<title>LMS ADMIN </title>
        <?php include 'bootstrap.php'; ?>
    </head>
    <body>
        <header>
            <?php include 'adminnavbar.php'; ?>
        </header>
        <main>
    	    <div class="card-header bg-success mt-3">
                <h1 class="text-center ">Profile</h1>
            </div> 
        
    
            <div class="col-md-6 col-sm-10 mx-auto fs-2 border border-dark border-3 p-2 m-5" >
    	    	<table class='mx-auto'>
    	    		<tbody >
    	    			<tr>
    	    				<td style='font-weight:bold'>ID</td>
    	    				<td>: <?php echo "{$row['adminid']}"?></td>
    	    			</tr>
    	    			<tr>
    	    				<td style='font-weight:bold'>NAME</td>
    	    				<td>: <?php echo "{$row['name']}"?> </td>
    	    			</tr>
                        <tr>
    	    				<td style='font-weight:bold'>AGE</td>
    	    				<td>: <?php echo "{$row['age']} Yrs"?></td>
    	    			</tr>
    	    			<tr>
    	    				<td style='font-weight:bold'>E-MAIL</td>
    	    				<td>: <?php echo "{$row['email']}" ?> </td>
    	    			</tr>
    	    			<tr>
    	    				<td style='font-weight:bold'>MOBILE</td>
    	    				<td>: <?php echo "{$row['phno']}"?></td>
    	    			</tr>
                        <tr>
    	    				<td style='font-weight:bold'>SALARY</td>
    	    				<td>: <?php echo "{$row['salary']} /-"?></td>
    	    			</tr>
    
                        <tr>
    	    				<td style='font-weight:bold'>REGISTER DATE</td>
    	    				<td>: <?php echo "{$row['registerdate']}"?></td>
    	    			</tr>
    
    	    		</tbody>
    	    	</table>
                <div class="d-flex flex-row justify-content-between m-4">
                    <a class="btn btn-primary" href="logout.php" >Logut</a>
                    <a class="btn btn-primary" href="adminchangepassword.php" target="_parent">change password</a>
                </div>
        
            </div>
        </main>
    
        
    </body>
</html>