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
    $isbn_search = $_POST['isbn_search'];
    $userid_search = $_POST['userid_search'];

    if(!empty($isbn_search) && !empty($userid_search)){
        $sql = "SELECT issued.*,books.title
        FROM issued 
        INNER JOIN books ON issued.bookid = books.isbn 
        WHERE books.isbn='$isbn_search' AND issued.studentid='$userid_search' ORDER BY issuedate";
    }
    else{
        $sql = "SELECT issued.*,books.title
        FROM issued 
        INNER JOIN books ON issued.bookid = books.isbn 
        WHERE books.isbn='$isbn_search' OR issued.studentid='$userid_search' ORDER BY issuedate";
    }

    $result = mysqli_query($conn, $sql);
}
elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['notreturned'])){
    $sql = "SELECT issued.*,books.title
    FROM issued 
    INNER JOIN books ON issued.bookid = books.isbn WHERE issued.returnstatus=0 ORDER BY issuedate";
    $result = mysqli_query($conn, $sql);
}

else {
    $sql = "SELECT issued.*,books.title
        FROM issued 
        INNER JOIN books ON issued.bookid = books.isbn ORDER BY issuedate";

    $result = mysqli_query($conn, $sql);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS ISSUED BOOKS</title>
    <?php include 'bootstrap.php'; ?>
    <style>
        .tablebox{
            border:2px solid black;
            overflow: scroll;
            height:400px;
        }
        .tablebox th {
            position: sticky;
            top: 0;
            background-color: #ccc;
            border-bottom: 2px solid black;
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
                    <label class="visually-hidden" for="isbn_search">Search by ISBN</label>
                    <input type="text" class="form-control my-2" id="isbn_search" name="isbn_search" placeholder="Search by ISBN" maxlength=10>
                    <input type="text" class="form-control" id="userid_search" name="userid_search" placeholder="Search by ID" maxlength=10>
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
                    <button type="submit" class="btn btn-primary" name="notreturned">Not Returned</button>
                </div>
            </form>
        </div>


        <div class="text-center ">
            <?php
                $no_of_books=mysqli_num_rows($result);
                echo "<h5 clas='fw-bold'>NO OF ROWS : {$no_of_books}</h5>";
            ?>
        </div>
        
        <div class="tablebox col-10 mx-auto">
            <table class="table">
                <tr>
                    <th>S.No</th>
                    <th>ISBN</th>
                    <th>STUDENT ID</th>
                    <th>Book Name</th>
                    <th>Issue Date</th>
                    <th>Return Date</th>
                    <th>Fine</th>
                </tr>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $count++ . "</td>";
                        echo "<td>" . $row['bookid'] . "</td>"; 
                        echo "<td>" . $row['studentid'] . "</td>"; 
                        echo "<td>" . $row['title'] . "</td>"; 
                        echo "<td>" . $row['issuedate'] . "</td>";
                        echo "<td>";
                        if ($row['returndate'] === NULL) {
                            echo "Not Returned<img src='images/wrong.png'style='width:20px'>";
                        } else {
                            echo "{$row['returndate']} <img src='images/correct.png' style='width:20px'>";

                        }
                        echo "</td>";

                        echo "<td>";
                        if ($row['returndate'] === NULL) {

                            $presentdate = date("Y-m-d");
                            $issuedate=$row['issuedate'];
                            $datetime1 = new DateTime($issuedate);
                            $datetime2 = new DateTime($presentdate);
                            $interval = $datetime1->diff($datetime2);
                            $daysDiff = $interval->days;
                            $fee = max(0, $daysDiff - 14) * 1;
                            echo $fee;

                        } else {
                            echo $row['fee'] ;
                        }
                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No books issued</td></tr>";
                }
                ?>
            </table>
        </div>
    </main>
    


</body>
</html>
