<?php 
session_start();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
    echo'<p>hi '  .$_SESSION['prenom'].' '.$_SESSION['nom'].' your session is started';
    
    ?>
</body>
</html>