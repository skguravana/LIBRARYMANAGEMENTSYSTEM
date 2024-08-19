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


$sql = "SELECT issued.*,books.title
        FROM issued 
        INNER JOIN books ON issued.bookid = books.isbn 
        WHERE issued.studentid='{$_SESSION['user_id']}'";


$result = mysqli_query($conn, $sql);

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
                height:300px;
            }
            .table tr th {
                background-color: #ccc; 
                border-bottom:2px solid black;
            }

        </style>
    </head>
    <body>
        
        <header>
            <?php include 'usernavbar.php';?>
        </header>

        <main>
            <div class="text-center">
                <img src="images/books.png" width="200px" >
            </div>
            <div class="tablebox col-10 mx-auto">
                <table class="table">
                    <tr>
                        <th>S.No</th>
                        <th>ISBN</th>
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
                            echo "<td>" . $row['title'] . "</td>"; 
                            echo "<td>" . $row['issuedate'] . "</td>";
                            echo "<td>";
                            if ($row['returndate'] === NULL) {
                                echo "Not Returned<img src='images/wrong.png'style='width:20px'>";
                            } else {
                                echo "{$row['returndate']} <img src='images/correct.png' style='width:20px'>";

                            }
                            echo "</td>";

                            echo "<td>" . $row['fee'] . "</td>";
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
