<?php

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="#">PIZZA</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="home.php">Home </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="page1.php">page1(current)</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="page2.php">page2</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
        <?php 
    echo "Email : " . $_SESSION["email"];
?>
        </a>
      </li>
      
      
    </ul>
    <form class="form-inline my-2 my-lg-0">

      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Logout</button>
    </form>

  </div>
</nav>
<?php 
    echo'<p>hi '  .$_SESSION['prenom'].' '.$_SESSION['nom'].' your session is started';
    echo"<br>";
    echo "COMING SOON!";
    
    ?>
</body>
</html>