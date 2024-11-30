<?php 

include("config.php");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>


body, html {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "Poppins", sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #333;
}

.wrapper {
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    width: 100%;
    max-width: 400px;
    padding: 30px 25px;
    box-sizing: border-box;
    animation: fadeInUp 1s ease-in-out;
}

h2 {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    color: #764ba2;
    margin-bottom: 30px;
    text-transform: uppercase;
}

form input[type="email"], 
form input[type="password"] {
    width: 100%;
    padding: 15px 20px;
    margin: 10px 0 20px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    background-color: #f9f9f9;
    transition: border 0.3s ease;
}

form input[type="email"]:focus, 
form input[type="password"]:focus {
    border-color: #667eea;
    background-color: #fff;
    outline: none;
}

form input[type="submit"] {
    width: 100%;
    padding: 15px;
    background: #667eea;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s ease;
}

form input[type="submit"]:hover {
    background: #764ba2;
}

#formFooter {
    margin-top: 20px;
    text-align: center;
}

#formFooter a {
    color: #667eea;
    text-decoration: none;
    font-size: 14px;
    font-weight: bold;
    transition: color 0.3s ease;
}

#formFooter a:hover {
    color: #764ba2;
}

.alert {
    background-color: #f8d7da;
    color: #721c24;
    padding: 10px 15px;
    border: 1px solid #f5c6cb;
    border-radius: 5px;
    margin-top: 20px;
}

.alert button {
    background: none;
    border: none;
    color: #721c24;
    font-size: 16px;
    float: right;
    cursor: pointer;
}

#logo {
    width: 100px; 
    margin-bottom: 20px; 
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>


</head>
<body>
<div class="wrapper fadeInDown">
  <div id="formContent">
  <img src="https://stradaeducation.org/wp-content/uploads/2020/07/logo-emsi.png" id="logo" alt="EMSI Logo" class="fadeIn first">
   <form action="" method="post">
      <input type="email" id="login" class="fadeIn second" name="emailName" placeholder="email">
      <span style='color:red'><?php
      echo $emailerreur
      ?></span>
      <input type="password" id="password" class="fadeIn third" name="passName" placeholder="password">
      <span style='color:red'><?php
      echo $passworderreur
      ?></span>
      <input name="submit" type="submit" class="fadeIn fourth" value="Log In">
    </form>

    <div id="formFooter">
      <a class="underlineHover" href="#">Forgot Password?</a>
      
    </div>
    <?php
        if (!empty($erormsg)) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>$erormsg</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
        }
        ?>

  </div>
</div>
</body>
</html>
