<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION["email"];


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_comment"])) {
    $file_email = $conn->real_escape_string($_POST["file_email"]);
    $comment = $conn->real_escape_string($_POST["comment"]);

    $query = "INSERT INTO comments (email, comment) VALUES ('$file_email', '$comment')";
    if ($conn->query($query)) {
        $message = "Comment added successfully.";
    } else {
        $message = "Error: " . $conn->error;
    }
}


$query = "SELECT * FROM uploads ORDER BY uploaded_at DESC";
$uploads = $conn->query($query);

$query = "SELECT * FROM comments WHERE email = '$email' ORDER BY created_at DESC";
$comments = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Professor Dashboard</a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <h1>Professor Dashboard</h1>

    <?php if (isset($message)): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>


    <h2>Uploaded Files</h2>
    <?php if ($uploads->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student Email</th>
                    <th>File Name</th>
                    <th>Download</th>
                    <th>Uploaded At</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $uploads->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['file_name']) ?></td>
                        <td><a href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank">Download</a></td>
                        <td><?= htmlspecialchars($row['uploaded_at']) ?></td>
                        <td>
                            <!-- Comment Form -->
                            <form method="POST">
                                <input type="hidden" name="file_email" value="<?= htmlspecialchars($row['email']) ?>">
                                <textarea name="comment" class="form-control" rows="2" placeholder="Write a comment..." required></textarea>
                                <button type="submit" name="add_comment" class="btn btn-primary btn-sm mt-2">Add Comment</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No files uploaded yet.</p>
    <?php endif; ?>

    <h2>Professor Notebook</h2>
    <form method="POST">
        <textarea name="comment" class="form-control" rows="4" placeholder="Write your notes here..." required></textarea>
        <button type="submit" name="add_comment" class="btn btn-success mt-2">Save Note</button>
    </form>

    <h3>Your Notes</h3>
    <?php if ($comments->num_rows > 0): ?>
        <ul class="list-group mt-3">
            <?php while ($row = $comments->fetch_assoc()): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($row['created_at']) ?>:</strong>
                    <?= htmlspecialchars($row['comment']) ?>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No notes yet.</p>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
