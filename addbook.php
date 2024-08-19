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
     
     if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $isbn=$_POST['isbn'];
        $title=$_POST['bookname'];
        $author=$_POST['author'];
        $genre = isset($_POST['genre']) ? $_POST['genre'] : null;
        $year=isset($_POST['year']) ? $_POST['year'] : null;
        $cost=$_POST['cost'];
        $count=$_POST['count'];


        $sql="INSERT INTO books(isbn,title,author,genre,publicationyear,cost,available) VALUES(?,?,?,?,?,?,?)";
        $stmt=mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt,'ssssiii',$isbn,$title,$author,$genre,$year,$cost,$count);
        if (mysqli_stmt_execute($stmt)) {
            $success = true;
        } else {
            $success = false;
            header('Location: ' . $_SERVER['PHP_SELF']);

        }
        mysqli_stmt_close($stmt);
     }
     mysqli_close($conn);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS ADDBOOK</title>
    <?php include 'bootstrap.php'; ?>
</head>
<body>
    
    <header>
        <?php include 'adminnavbar.php'; ?>
    </header>
    
    <main>
        <div class="formbox mx-auto  p-3 m-4">
            <div class='text-center'>
                <?php
                    if (isset($success)) {
                        if ($success) {
                            echo "<h2 class='text-success'>Added successful!</h2>";
                        } else {
                            echo "<h2 class='text-danger'>Add failed!</h2>";
                        }
                    }
                    ?>

                </div>

            <h1 class="text-center bg-info mb-3">ADD-BOOK</h1> 
            <form   id="form" method="post" class=" fw-bold"> 
                <div class="d-flex col-12">
                    <div class="mb-3 col-4 mx-auto">
                        <label for="bookname" class="form-label">Book Name:</label> 
                        <input type="text" id="bookname" name="bookname" class="form-control" placeholder="Book-Name" required> 
                    </div>
                    <div class="mb-3 col-4 mx-auto">
                        <label for="isbn" class="form-label">ISBN:</label> 
                        <input type="number" id="isbn" name="isbn" class="form-control" placeholder="ISBN" required> 
                        <p class="text-primary" style="font-size:14px">An ISBN is an International Standard Book Number.ISBN Must be unique</p>
                    </div>
                </div>
                <div class="d-flex col-12">
                    <div class="mb-3 col-4 mx-auto">
                        <label for="author" class="form-label">Author:</label> 
                        <input type="text" id="author" name="author" class="form-control" placeholder="Author" required > 
                    </div>
                    <div class="mb-3 col-4 mx-auto">
                        <label for="user_password" class="form-label">Genre:</label> 
                        <select class="form-control" name="genre" id="genre">
                            <option value="NULL">Other</option>
                            <option value="Fiction">Fiction</option>
                            <option value="Non-fiction">Non-Fiction</option>
                            <option value="Poetry">Poetry</option>
                            <option value="Maths">Maths</option>

                        </select>
                    </div>
                </div>
                <div class="d-flex col-12">
                    <div class="mb-3 col-4 mx-auto">
                        <label for="year" class="form-label">Publication Year</label> 
                        <input type="number" id="year" name="year" class="form-control" placeholder="Year" pattern="[0-9]{4}"  > 
                    </div>
                    <div class="mb-3 col-4 mx-auto">
                        <label for="cost" class="form-label">Price:</label> 
                        <input type="number" id="cost" name="cost" class="form-control" placeholder="Book Price" min="0" required> 
                    </div>
                </div>
                <div class="col-12 d-flex ">
                    <div class="mb-3 col-4 mx-auto">
                        <label for="count" class="form-label">No Of Books:</label> 
                        <input type="number" id="count" name="count" class="form-control" placeholder="No Of Books" min="1" required> 
                    </div>
                    <div class="col-4 mx-auto">
                        
                    </div>  

                </div>
                
                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-primary">Submit </button>
                </div>
            </form> 
        </div>
    </main>

    
</body>
</html>