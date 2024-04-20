<!DOCTYPE html>
<html lang="fr">
<meta charset="utf-8">
<link rel="stylesheet" href="stylesheet.css">

<head>
    <?php
    require("fichier-auxilliaire/inc_connexion.php");
    $user_input_login = isset($_POST['user_input_login']) ? $_POST['user_input_login'] : "";
    $user_input_password = isset($_POST['user_input_password']) ? $_POST['user_input_password'] : "";
    ?>
    <title>Connexion</title>
    
</head>

<body>
    <main>
        <div class="bloc-login">
            <?php
            if (empty($user_input_login) || empty($user_input_password)) {
                echo '<div class="message"><p>Les champs n\'ont pas été correctement remplis</p></div>';
            } else {
                $resultat = $mysqli->query('SELECT user_login, user_password FROM user WHERE user_login = "' . $user_input_login . '"');
                $rows = $resultat->fetch_array();

                if (empty($rows)) {
                    echo '<div class="message"><p>Ce login n\'existe pas</p></div>';
                } else {

                    if ($user_input_password == $rows['user_password']) {
                        session_start();
                        $_SESSION['user_login'] = $user_input_login;
                        header('Location: index.php');
                        exit();
                    } else {
                        echo '<div class="message"><p>Mot de passe incorrect</p></div>';
                    }
                }
            }
            ?>
            <form action=<?php echo $_SERVER["PHP_SELF"]; ?> method="POST" id="form-login">
                <input type="text" id="user_input_login" name="user_input_login" placeholder="Login" required>
                <input type="password" id="user_input_password" name="user_input_password" placeholder="Password"
                    required>
                <input type="submit" id="submit" value="valider">
            </form>
            <div class="lien-accueil">
                <a href="inscription.php">Incription</a>
                <a href="index.php">Allez a la page d'accueil</a>
            </div>
        </div>
    </main>
</body>

</html>