<?php
session_start(); 

// Redirect to login if not logged in
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

// Retrieve session variables
$firstname = $_SESSION["firstname"];
$lastname = $_SESSION["lastname"];
$email = $_SESSION["email"];

// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["uploaded_file"])) {
  $target_dir = "uploads/";
  if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true); // Create uploads directory if not exists
  }
  $file_name = basename($_FILES["uploaded_file"]["name"]);
  $target_file = $target_dir . $file_name;
  $uploadOk = 1;

  // Check file type
  $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  if ($file_type != "php") {
      $uploadOk = 0;
      echo "<div class='alert alert-danger'>Only PHP files are allowed.</div>";
  }

  // Attempt to upload
  if ($uploadOk && move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $target_file)) {
      // Insert file details into database
      $stmt = $conn->prepare("INSERT INTO uploads (email, file_name, file_path) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $email, $file_name, $target_file);
      $stmt->execute();
      $stmt->close();

      echo "<div class='alert alert-success'>PHP file uploaded successfully.</div>";
  } else {
      echo "<div class='alert alert-danger'>File upload failed.</div>";
  }
}


// Handle commentary submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["comment"])) {
    $comment = htmlspecialchars($_POST["comment"]);
    $stmt = $conn->prepare("INSERT INTO comments (email, comment) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $comment);
    $stmt->execute();
    $stmt->close();

    echo "<div class='alert alert-success'>Comment submitted successfully.</div>";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Interface</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Student Portal</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
        <span class="navbar-text">
            Logged in as: <?php echo $email; ?>
        </span>
    </div>
</nav>
<div class="container mt-4">
    <h1>Welcome, <?php echo "$firstname $lastname"; ?>!</h1>
    <p>Your email is: <?php echo $email; ?></p>

    <h2>Upload a File</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="uploaded_file">Choose file to upload:</label>
            <input type="file" name="uploaded_file" id="uploaded_file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <h2 class="mt-4">Add a Comment</h2>
    <form action="" method="POST">
        <div class="form-group">
            <textarea name="comment" class="form-control" rows="3" placeholder="Write your comment here..." required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>

    <h2 class="mt-4">Your Comments</h2>
    <ul class="list-group">
        <?php
        // Fetch and display comments by the user
        $stmt = $conn->prepare("SELECT comment, created_at FROM comments WHERE email = ? ORDER BY created_at DESC");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            echo "<li class='list-group-item'><strong>" . htmlspecialchars($row["created_at"]) . ":</strong> " . htmlspecialchars($row["comment"]) . "</li>";
        }
        $stmt->close();
        ?>
    </ul>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
