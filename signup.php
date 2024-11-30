<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";


$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sucMsg = "";
$nameValue = "";
$lnameValue = "";
$emailValue = "";
$passwordValue = "";
$errorMsg = "";

if (isset($_POST['submit'])) {
    $nameValue = $_POST['fname'];
    $lnameValue = $_POST['lname'];
    $emailValue = $_POST['email'];
    $passwordValue = $_POST['password'];

  
    if (empty($nameValue) || empty($emailValue) || empty($lnameValue) || empty($passwordValue)) {
        $errorMsg = "All fields must be filled";
    } elseif (strlen($passwordValue) < 8) {
        $errorMsg = "Password should contain at least 8 characters!";
    } elseif (!preg_match('/[A-Z]+/', $passwordValue)) {
        $errorMsg = "Please insert at least 1 uppercase letter!";
    } else {
        
        $passwordHash = password_hash($passwordValue, PASSWORD_DEFAULT);

        $sql = "INSERT INTO cclients (firstname, lastname, email, password) VALUES ('$nameValue', '$lnameValue', '$emailValue', '$passwordHash')";

        if (mysqli_query($conn, $sql)) {
            $sucMsg = "New record created successfully";
        } else {
            $errorMsg = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .form-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }

        .form-container h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .form-control {
            border: 2px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: #5fbae9;
            box-shadow: 0 0 5px rgba(95, 186, 233, 0.5);
        }

        .btn-submit {
            background-color: #56baed;
            border: none;
            padding: 10px 20px;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background-color: #39ace7;
        }

        .alert {
            margin-bottom: 20px;
        }

        .footer-text {
            margin-top: 15px;
            text-align: center;
            font-size: 0.9rem;
        }

        .footer-text a {
            color: #56baed;
            text-decoration: none;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Sign Up</h2>

        <?php if (!empty($errorMsg)) : ?>
            <div class="alert alert-danger">
                <strong><?php echo $errorMsg; ?></strong>
            </div>
        <?php endif; ?>

        <?php if (!empty($sucMsg)) : ?>
            <div class="alert alert-success">
                <strong><?php echo $sucMsg; ?></strong>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="text" class="form-control" name="fname" placeholder="First Name" value="<?php echo $nameValue; ?>">
            <input type="text" class="form-control" name="lname" placeholder="Last Name" value="<?php echo $lnameValue; ?>">
            <input type="email" class="form-control" name="email" placeholder="Email">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <input type="password" class="form-control" name="passwo" placeholder="Confirm Password">
            <button type="submit" name="submit" class="btn-submit">Sign Up</button>
        </form>

        <div class="footer-text">
            Already have an account? <a href="login.php">Login</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
