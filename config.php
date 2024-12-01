<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";
$emailerreur = "";
$passworderreur = "";
$erormsg = "";
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
            $user = $result->fetch_assoc();
            
            if (password_verify($passwordValue, $user['password'])) {
               
                session_start();
                $_SESSION["email"] = $emailValue;
                $_SESSION["firstname"] = $user["firstname"];
                $_SESSION["lastname"] = $user["lastname"];
                $_SESSION["fonction"] = $user["fonction"]; 

                switch ($user['fonction']) {
                    case 'admin':
                        header("Location: home_admin.php");
                        break;
                    case 'prof':
                        header("Location: home_prof.php");
                        break;
                    case 'student':
                        header("Location: home.php");
                        break;
                    default:
                        $erormsg = "Invalid function specified.";
                }
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
