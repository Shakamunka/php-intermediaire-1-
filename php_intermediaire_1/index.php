<!DOCTYPE html>
<html lang="fr">


<head>
    <?php
    require("fichier-auxilliaire/inc_connexion.php");
    session_start();
    ?>
    <title>Accueil</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="stylesheet.css">
</head>

<body>
    <header>

        <nav class="nav-menu">
            <ul>
                <?php require('fichier-auxilliaire/inc_menu.php') ?>
            </ul>
        </nav>
    </header>
    <main>
        <div class="bloc-1">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                <h1>Recherche de ville</h1>
                <label for="nom_ville">Nom de la ville :</label>
                <input type="text" id="nom_ville" name="nom_ville">
                <input type="submit" value="Rechercher">
            </form>
            <?php
            $user_login = isset($_SESSION['user_login']) ? $_SESSION['user_login'] : '';
            if ($user_login) {
                $query_user = "SELECT user_id FROM user WHERE user_login = '$user_login'";
                $result_user = $mysqli->query($query_user);
                while ($rows_user = $result_user->fetch_assoc()) {
                    $user_id = $rows_user['user_id'];
                }
            }

            if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['nom_ville'])) {
                $nom_ville = $_GET['nom_ville'];
                $query = "SELECT ville_id, ville_nom, ville_texte FROM villes WHERE ville_nom = '$nom_ville'";
                $result = $mysqli->query($query);

                if ($result->num_rows > 0) {
                    echo "<h2>Résultats de la recherche :</h2>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class ='nom-ville'>Nom de la ville : " . $row['ville_nom'] . "</div><br>";
                        echo "<div class ='infos-ville'>Information sur la ville : " . $row['ville_texte'] . "</div>";

                        if ($user_login) {
                            $ville_id = $row['ville_id'];
                            $query_search = "INSERT INTO search (user_id, ville_id) VALUES ($user_id, $ville_id)";
                            $result_search = $mysqli->query($query_search);

                            if ($result_search) {
                                echo "<br>Recherche enregistrée avec succès.";
                            } else {
                                echo "Erreur lors de l'enregistrement de la recherche : ";
                            }


                        }
                    }
                } else {
                    echo "Erreur lors de la recherche : cette ville n'est pas répertoriée";
                }

            }
            if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['ville_id'])) {
                $ville_id = $_GET['ville_id'];
                $query = "SELECT ville_id, ville_nom, ville_texte FROM villes WHERE ville_id = '$ville_id'";
                $result = $mysqli->query($query);

                if ($result && $result->num_rows > 0) {
                    echo "<h2>Résultats de la recherche :</h2>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class ='nom-ville'>Nom de la ville : " . $row['ville_nom'] . "</div><br>";
                        echo "<div class ='infos-ville'>Information sur la ville : " . $row['ville_texte'] . "</div>";

                    }
                } else {
                    echo "Erreur lors de la recherche : cette ville n'est pas répertoriée";
                }

            }
            ?>
            <table>

                <tr>
                    <td>
                        <h2>Historique de recherche</h2>
                    </td>
                </tr>
                <?php

                if ($user_login) {
                    $query_search_user = "SELECT search.search_id, villes.ville_nom, villes.ville_id 
                        FROM search 
                        INNER JOIN villes ON search.ville_id = villes.ville_id 
                        WHERE search.user_id = '$user_id'
                        ORDER BY search.search_id DESC";

                    $result_search_user = $mysqli->query($query_search_user);

                    if ($result_search_user) {
                        while ($row_search_user = $result_search_user->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td><a href="index.php?ville_id='.$row_search_user["ville_id"].'">' . $row_search_user["ville_nom"] . '</a></td>';
                            echo '</tr>';
                        }

                    } else {
                        echo 'Erreur lors de la récupération de l\'historique : ';
                    }
                    
                } else {
                    echo '<tr><td>Aucun historique disponible.</td></tr>';
                }
                $mysqli->close();
                ?>
            </table>
        </div>


    </main>
</body>

</html>