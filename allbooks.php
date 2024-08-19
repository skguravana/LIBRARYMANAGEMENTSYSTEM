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
    $name_search = $_POST['name_search'];

    $isbn_search = trim(strtolower($isbn_search));
    $name_search = trim(strtolower($name_search));

    $sql = "SELECT * FROM books WHERE isbn = '$isbn_search' 
            OR LOWER(replace(title,' ','')) =  LOWER(REPLACE('$name_search',' ',''))
            OR LOWER(replace(author,' ','')) = LOWER(REPLACE('$name_search',' ','')) 
            ORDER BY updatedate DESC";
    $result = mysqli_query($conn, $sql);
} else {
    $sql = "SELECT * FROM books ORDER BY updatedate DESC";
    $result = mysqli_query($conn, $sql);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS LRIBRARY BOOKS</title>
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
                <div class="col-auto d-flex">
                    <label class="visually-hidden" for="isbn_search">Search by ISBN</label>
                    <input type="text" class="form-control mx-2" id="isbn_search" name="isbn_search" style="height:40px;" placeholder="Search by ISBN">
                    <input type="text" class="form-control mx-2" id="name_search" name="name_search" style="height:40px;" placeholder="BookK/Author">
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
                $no_of_books=mysqli_num_rows($result);
                echo "<h5 clas='fw-bold'>NO OF BOOKS : {$no_of_books}</h5>";
            ?>
        </div>
        
        <div class="tablebox col-10 mx-auto">
            
            <table class="table">
                <tr>
                    <th>S.No</th>
                    <th>ISBN</th>
                    <th>Book Name</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Year</th>
                    <th>Cost</th>
                    <th>Available</th>
                    <th>Update Date</th>
                </tr>
                <?php
                
                if ($no_of_books > 0) {
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $count++ . "</td>";
                        echo "<td>" . $row['isbn'] . "</td>"; 
                        echo "<td>" . $row['title'] . "</td>"; 
                        echo "<td>" . $row['author'] . "</td>";
                        echo "<td>" . $row['genre'] . "</td>";
                        echo "<td>" . $row['publicationyear'] . "</td>";
                        echo "<td>" . $row['cost'] . "</td>";

                        echo "<td>";
                        if ($row['available']<1) {
                            echo "Not Available";
                        } else {
                            echo $row['available'];
                        }
                        echo "</td>";

                        echo "<td>" . $row['updatedate'] . "</td>";
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
