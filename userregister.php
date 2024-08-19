<?php
error_reporting(0);

$conn = mysqli_connect('localhost', 'root', '', 'lms');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['user_name'];
    $password = $_POST['user_password'];
    $email = $_POST['user_email'];
    $phno = $_POST['user_mobile'];

 
    $sql = "SELECT MAX(sno) AS max_id FROM regstudents";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $max_id = $row['max_id']; 

    
    $id = 'LMS'. str_pad($max_id+1, 7, '0', STR_PAD_LEFT);


    $sql = "INSERT INTO regstudents (id, name, email, phno, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $id, $name, $email, $phno, $password);

    if (mysqli_stmt_execute($stmt)) {
        $success = true;
        $_SESSION['registration_success'] = true; 
    } else {
        $success = false;
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>LMS USER REGISTER</title>
    <?php include 'bootstrap.php'; ?>
</head>
<body>
    <header>
        <?php include 'indexnavbar.php';?>
    </header>

    <main>
        <div class="formbox col-11 col-md-5 mx-auto  p-3 mt-4">
            <div class='text-center'>
                    <?php
                    if (isset($success)) {
                        if ($success) {
                            echo "<h2 class='text-success'>Registration successful!</h2>";
                        } else {
                            echo "<h2 class='text-danger'>Registration failed!</h2>";
                        }
                    }
                    ?>
            </div>

            <h1 class="text-center bg-success rounded-pill">Do - Register!</h1> 
            <form   id="form" method="post" onsubmit="return validate()" > 
                <div class="mb-3">
                    <label for="user_name" class="form-label">Name:</label> 
                    <input type="text" id="user_name" name="user_name" class="form-control" placeholder="Name" required> 
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label> 
                    <input type="text" id="email" name="user_email" class="form-control" placeholder="E-mail" required> 
                </div>
                <div class="mb-3">
                    <label for="mobile" class="form-label">Contact:</label> 
                    <input type="text" inputmode="numeric" pattern="[0-9]{10}" oninput="this.value = this.value.replace(/[^0-9]/g, '');" id="mobile" name="user_mobile" class="form-control" placeholder="000-0000-000"  required maxlength=10> 
                </div>
                <div class="mb-3">
                    <label for="user_password" class="form-label">Password:</label> 
                    <input type="password" id="user_password" name="user_password" class="form-control" placeholder="Password"  required>
                </div>
                <div class="mb-3">
                    <label for="repassword" class="form-label">Confirm Password:</label> 
                    <input type="password" id="repassword" name="repassword" class="form-control" placeholder="Confirm password"  required> 
                </div>
                <p class="text-danger" id="error"></p>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" id="terms" class="form-check-input" required>
                    <label class="form-check-label" for="terms">I accept Terms of Use and Privacy Policy of the Website.</label>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" onclick="validate()">Submit </button>
                </div>
            </form> 
        </div>
    </main>

    <script>

        function validate() {
            var password = document.querySelector('#user_password').value;
            var repassword = document.querySelector('#repassword').value;
        
            if (password !== repassword) {
                document.querySelector('#error').textContent = "Confirm password does not match password";
                return false; 
            }
            return true;
        }



    </script>

    
</body>
</html>