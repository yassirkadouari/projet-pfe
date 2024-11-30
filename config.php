<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";
$emailerreur = "";
$passworderreur = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_POST["submit"])) {
    $emailValue = $_POST["emailName"];
    $passwordValue = $_POST["passName"];

    if ($emailValue == "") {
        $emailerreur = "Email must be filled out!";
    } elseif (!preg_match("/\w+@emsi\.ma$/", $emailValue)) {
        $emailerreur = "Email must respect EMSI email directive";
    } elseif ($passwordValue == "") {
        $passworderreur = "Password must be filled out!";
    } else {
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT * FROM cclients WHERE email='$emailValue'";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc(); // Récupérer les données de l'utilisateur
            
            // Vérifier le mot de passe hashé
            if (password_verify($passwordValue, $user['password'])) {
                // Mot de passe valide
                session_start();
                $_SESSION["email"] = $emailValue;
                $_SESSION["firstname"] = $user["firstname"]; // Utiliser les données récupérées
                $_SESSION["lastname"] = $user["lastname"];

                header("location:home.php");
                exit();
            } else {
                $erormsg = "Mot de passe incorrect.";
            }
        } else {
            $erormsg = "Aucun utilisateur trouvé avec cet email.";
        }
    }
}
?>
