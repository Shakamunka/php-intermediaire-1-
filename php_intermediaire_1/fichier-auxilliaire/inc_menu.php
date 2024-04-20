<?php
if (isset($_SESSION['user_login'])) {
    echo "<li><p>Bonjour " . $_SESSION['user_login'] . ", bienvenue</p></li> <li><a href='logout.php'>Deconnexion</a></li>";
} elseif (empty($_SESSION['user_login'])) {
    echo '<li><a href="inscription.php">Premiére Visite ?</a></li>';
    echo '<li><a href="login.php">Déjà inscrits ?</a></li>';
}
?>